<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Domain;

class Cell
{
    public function __construct(
        public mixed $value,
        public readonly int $rowIndex
    ) {
    }

    public function isMine(): bool
    {
        return $this->value === '*';
    }

    public function increase(): void
    {
        ++$this->value;
    }

    public function isEmpty(): bool
    {
        return !$this->isMine();
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

}
