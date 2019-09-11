<?php declare(strict_types=1);

function minutesToSeconds(int $num_minutes): int {
    return (int) (new DateInterval("PT${num_minutes}M"))->format("s");
}
