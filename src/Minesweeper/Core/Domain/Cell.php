<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Domain;

class Cell
{
    public function __construct(
        public readonly mixed $value,
        public readonly int $rowIndex
    ) {
    }

    public function isMine(): bool
    {
        return $this->value === '*';
    }
}
