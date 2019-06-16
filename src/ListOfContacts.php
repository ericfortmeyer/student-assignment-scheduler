<?php

namespace StudentAssignmentScheduler;

use \Ds\Set;
use \Ds\Map;

/**
 * A unique set of contact instances.
 */
class ListOfContacts
{
    const NOT_SETUP_YET = "no emails set up yet",
                 TOO_MANY_EMAILS_RETURNED = "too many returned";
                
    /**
     * @var Set $contacts
     */
    protected $contacts;

    /**
     * @var Map $FullnameHashMappedToContacts
     */
    protected $FullnameHashMappedToContacts;

    /**
     * Creates a ListOfContacts instance.
     *
     * @throws \InvalidArgumentException
     * @param array<int,string|Contact> $contacts
     */
    public function __construct(array $contacts = [])
    {
        $this->contacts = new Set();
        $validContactsOrThrowException = function ($contact_info) {
            return is_string($contact_info)
                ? new Contact($contact_info)
                : (
                    is_a($contact_info, Contact::class)
                        ? $contact_info
                        : (function () {
                            $message = "Contact info should be of type string or " . Contact::class;
                            throw new \InvalidArgumentException($message);
                        })()
                    );
        };

        $this->contacts = new Set(array_map($validContactsOrThrowException, $contacts));
        $this->FullnameHashMappedToContacts = $this->contacts->reduce(
            function (Map $Map, Contact $contact): Map {
                $key = sha1((string) $contact->fullname());
                return $Map->union(
                    new Map([$key => $contact])
                );
            },
            new Map()
        );
    }

    public function are(): array
    {
        return $this->contacts->toArray();
    }

    public function toSet(): Set
    {
        return $this->contacts;
    }

    /**
     * Returns a contact with the given index.
     *
     * @param int $index
     * @return Contact The selected contact
     */
    public function get(int $index): Contact
    {
        return $this->contacts->get($index);
    }

    /**
     * Removes the given contact.
     *
     * @param Contact $contact The contact to remove
     * @return void
     */
    public function remove(Contact $contact): void
    {
        $this->contacts->remove($contact);
    }

    /**
     * Combine two ListOfContact instances.
     *
     * A new ListOfContacts containing all of the values of
     * the current instance as well as the values of
     * another ListOfContacts.
     *
     * @suppress PhanPossiblyNullTypeMismatchProperty
     *
     * @param self $ListOfContacts
     * @return self
     */
    public function union(self $ListOfContacts): self
    {
        $copyOfContacts = clone $this;

        $copyOfContacts->contacts = $copyOfContacts
            ->toSet()
            ->union(
                $ListOfContacts->toSet()
            ); // \Ds\Set::union triggers Phan error

        return $copyOfContacts;
    }

    /**
     * Returns the result of applying a callback to
     * each value.
     *
     * @param \Closure $callable
     * @return self
     */
    public function map(\Closure $callable): self
    {
        $copyOfContacts = clone $this;
        $copyOfContacts->contacts = new Set(
            array_map(
                $callable,
                $copyOfContacts->toArray()
            )
        );
        return $copyOfContacts;
    }

    /**
     * Reduces the ListOfContacts to a single
     * instance using a callback function.
     *
     * @param \Closure $callable
     * @return mixed
     */
    public function reduce(\Closure $callable)
    {
        return $this->contacts->reduce($callable);
    }

    public function toArray(): array
    {
        return $this->contacts->toArray();
    }

    /**
     * Returns whether any value in the ListOfContacts
     * contains the given value.
     *
     * @param string $value
     * @return bool
     */
    public function contains(string $value): bool
    {
        $hasContactContainingTheValue = function ($carry, Contact $contact) use ($value): bool {
            return $carry or $contact->contains($value);
        };

        return $this->reduce($hasContactContainingTheValue);
    }

    /**
     * Creates a new instance of ListOfContacts having the contact that was given.
     *
     * @param Contact $contact
     * @return self
     */
    public function withContact(Contact $contact): self
    {
        return $this->union(new self([$contact]));
    }

    /**
     * Attempt to find a value that has the given fullname.
     *
     * @param Fullname $fullname
     * @return MaybeContact
     */
    public function findByFullname(Fullname $fullname)
    {
        $key = sha1((string) $fullname);
        $doIfNotFound = function (): bool {
            return false;
        };
        return MaybeContact::init(
            $this->FullnameHashMappedToContacts->get($key, $doIfNotFound)
        );
    }

    /**
     * Attempt to find a value that has the given guid.
     *
     * @param Guid $guid
     * @return MaybeContact
     */
    public function findByGuid(Guid $guid)
    {
        $searchUsingGuid = function ($alreadyFound, Contact $contact) use ($guid) {
            $guidMatches = function (Guid $guid, Contact $contact) {
                return $contact->hasGuid($guid);
            };

            $result = $alreadyFound
                ? $alreadyFound
                : ($guidMatches($guid, $contact) ? $contact : false);

            return MaybeContact::init($result);
        };

        return $this->reduce($searchUsingGuid);
    }

    /**
     * Attempt to find a value that has a guid of the given sha1 hash.
     *
     * @param string $sha1_of_guid
     * @return MaybeContact Represents the result of searching for the contact
     */
    public function findBySha1OfGuid(string $sha1_of_guid): MaybeContact
    {
        $guidOfContactIsSha1OfGivenGuid = function (Contact $contact) use ($sha1_of_guid): bool {
            return sha1($contact->guid()) === $sha1_of_guid;
        };
        try {
            $result = $this->contacts
                ->filter($guidOfContactIsSha1OfGivenGuid)
                ->first();
        } catch (\UnderflowException $e) {
            $result = false;
        }

        return MaybeContact::init($result);
    }

    protected function throwTooManyReturned()
    {
        throw new \Exception(static::TOO_MANY_EMAILS_RETURNED);
    }

    public function getArrayCopy(): array
    {
        return array_map(
            function (Contact $contact): array {
                return $contact->getArrayCopy();
            },
            $this->contacts->toArray()
        );
    }

    public function exchangeArray($array): array
    {
        return (new self($array))->contacts->toArray();
    }
}
