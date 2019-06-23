<?php declare(strict_types=1);
/**
 * This file is part of student-assignment-scheduler.
 *
 * Copywright (c) Eric Fortmeyer.
 * Licensed under the MIT License. See LICENSE in the project root folder for license information.
 *
 * @author Eric Fortmeyer <e.fortmeyer01@gmail.com>
 */

namespace StudentAssignmentScheduler\Persistence;

interface ImmutableModifiablePersistenceInterface
{
    public function remove($item): self;
    public function update($original_item, $new_item): self;
    public function toArray(): array;
    public function asMap(): \Ds\Map;
}
