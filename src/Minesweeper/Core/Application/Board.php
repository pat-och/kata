<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;

use App\Minesweeper\Core\Domain\Cell;

class Board
{
    /** @var Cell[] */
    private array $cells = [];

    public function addCells(Cell ...$cells): void
    {
        $this->cells = $cells;
    }

    public function cell(int $i): Cell
    {
        return $this->cells[$i];
    }
}
