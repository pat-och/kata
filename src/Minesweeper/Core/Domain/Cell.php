<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Domain;

class Cell
{
    /** @var string */
    const MINE = '*';

    /** @var string */
    const DOT = '.';

    public function __construct(
        public int|string $value,
        public readonly int $row,
        public readonly int $column
    ) {
        if ($this->value === self::DOT) $this->value = 0;
    }

    public function hasMine(): bool
    {
        return $this->value === self::MINE;
    }

    public function isEmpty(): bool
    {
        return !$this->hasMine();
    }

    public function increase(): void
    {
        if ($this->isEmpty()) ++$this->value;
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }
}
