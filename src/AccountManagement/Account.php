<?php

namespace StudentAssignmentScheduler\AccountManagement;

use \DateTimeImmutable;
use \DateTimeInterface;

final class Account extends \ArrayObject implements \JsonSerializable
{
    private const CUSTOM_DATETIME_FORMAT = "Y-m-d H:i:s";
    /**
     * @var int $id
     */
    private $id = 0;

    /**
     * @var DateTimeImmutable $created_on
     */
    private $created_on;

    /**
     * Creates an account instance.
     *
     * @param int|null $id
     * @param DateTimeImmutable|null $created_on
     */
    public function __construct(?int $id = null, ?DateTimeImmutable $created_on = null)
    {
        $this->id = $id ?? random_int(1, PHP_INT_MAX);
        $this->created_on = $created_on ?? new DateTimeImmutable();
    }

    public static function from(array $account_info): self
    {
        return new self($account_info["id"], new DateTimeImmutable($account_info["created_on"]));
    }

    public function getArrayCopy(): array
    {
        return [$this->id, $this];
    }

    public function jsonSerialize()
    {
        return ["id" => $this->id, "created_on" => $this->created_on->format(DateTimeInterface::ATOM)];
    }

    public function __toString()
    {
        // simplifies sql query building
        return ":id{$this->id}, :created_on{$this->id}";
    }

    public function sqlInputParameters(): array
    {
        return [":id{$this->id}" => $this->id, ":created_on{$this->id}" => $this->created_on->format("r")];
    }
}
