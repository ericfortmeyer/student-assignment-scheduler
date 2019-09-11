<?php declare(strict_types=1);
/**
 * JW Virtual Assistant Login Account Management.
 * 
 * Copywright (c) Eric Fortmeyer.
 * See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 * @package Account Management
 */

namespace jwvirtualassistant\AccountManagement;

use \stdClass;
use \DateTimeImmutable;

/**
 * Represents an application user's account.
 */
class Account
{
    /**
     * A Username instance.
     * 
     * @var Username $username
     */
    protected $username;

    /**
     * A Password instance.
     * 
     * @var Password $password
     */
    protected $password;

    /**
     * An EmailOption instance.
     * 
     * @var EmailOption $email
     */
    protected $email;

    /**
     * A DateTime instance representing when the account
     * was created.
     * 
     * @var DateTimeImmutable $created_on
     */
    protected $created_on;

    /**
     * A DateTime instance representing when the account
     * was modified.
     * 
     * @var MaybeDateTime $modified_on
     */
    protected $modified_on;

    /**
     * Create the instance.
     *
     * @param stdClass $object
     */
    public function __construct(stdClass $object)
    {
        $this->username = new Username($object->username);
        $this->password = new Password([$object->password]);
        $this->email = new EmailOption($object->email);
        $this->created_on = new DateTimeImmutable($object->created_on);
        
        if (\property_exists($object, "modified_on")) {
            $this->modified_on = new MaybeDateTime($object->modified_on);
        }
    }

    /**
     * Return username.
     *
     * @return Username
     */
    public function getUsername(): Username
    {
        return $this->username;
    }

    /**
     * Return password.
     *
     * @return Password
     */
    public function getPassword(): Password
    {
        return $this->password;
    }

    /**
     * Return representation of email.
     *
     * @return EmailOption
     */
    public function getEmail(): EmailOption
    {
        return $this->email;
    }

    /**
     * Return time of creation.
     *
     * @return DateTimeImmutable
     */
    public function getCreationTime(): DateTimeImmutable
    {
        return $this->created_on;
    }

    /**
     * Return a representation of the modification time.
     *
     * @return MaybeDateTime
     */
    public function getModificationTime(): MaybeDateTime
    {
        return $this->modified_on;
    }
}
