<?php

namespace StudentAssignmentScheduler\Classes;

use \Ds\Set;

class ListOfContacts
{
    public const NOT_SETUP_YET = "no emails set up yet",
                 TOO_MANY_EMAILS_RETURNED = "too many returned";
                
    /**
     * @var Set $contacts
     */
    protected $contacts;

    /**
     * @throws \InvalidArgumentException
     * @param array<int,string|Contact> $contacts
     */
    public function __construct(array $contacts = [])
    {
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
    }

    public function are(): array
    {
        return $this->contacts->toArray();
    }

    public function toSet(): Set
    {
        return $this->contacts;
    }

    public function get(int $index): Contact
    {
        return $this->contacts->get($index);
    }

    public function remove(Contact $contact): void
    {
        $this->contacts->remove($contact);
    }

    public function union(self $ListOfContacts): self
    {
        $copyOfContacts = clone $this;
        $copyOfContacts->contacts = $copyOfContacts
            ->toSet()
            ->union(
                $ListOfContacts->toSet()
            );
        return $copyOfContacts;
    }

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

    public function reduce(\Closure $callable)
    {
        return $this->contacts->reduce($callable);
    }

    public function toArray(): array
    {
        return $this->contacts->toArray();
    }

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
     * @param Fullname $fullname
     * @return Contact|bool
     */
    public function findByFullname(Fullname $fullname)
    {
        $searchUsingFullname = function ($alreadyFound, Contact $contact) use ($fullname) {
            $fullnameMatches = function (Fullname $fullname, Contact $contact): bool {
                return $contact->is($fullname);
            };

            return $alreadyFound
                ? $alreadyFound
                : ($fullnameMatches($fullname, $contact) ? $contact : false);
        };

        return $this->reduce($searchUsingFullname);
    }

    /**
     * @param Guid $guid
     * @return Contact|bool
     */
    public function findByGuid(Guid $guid)
    {
        $searchUsingGuid = function ($alreadyFound, Contact $contact) use ($guid) {
            $guidMatches = function (Guid $guid, Contact $contact) {
                return $contact->hasGuid($guid);
            };

            return $alreadyFound
                ? $alreadyFound
                : ($guidMatches($guid, $contact) ? $contact : false);
        };

        return $this->reduce($searchUsingGuid);
    }

    protected function throwTooManyReturned()
    {
        throw new \Exception(static::TOO_MANY_EMAILS_RETURNED);
    }
}
