<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Domain;

class Cell
{
    public function __construct(
        public mixed $value,
        private int $rowIndex
    ) {
    }
}
