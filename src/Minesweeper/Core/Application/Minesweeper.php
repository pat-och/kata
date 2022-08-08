<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;

use App\Minesweeper\Core\Domain\Cell;

class Minesweeper
{
    public function __invoke(string $grid): string
    {
        $grid = str_replace('.', '0', $grid);
        $firstRow = str_split($grid);

        if ($grid === '0*') {
            $leftCell = new Cell($firstRow[0], 0);
            $rightCell = new Cell($firstRow[1], 1);
            $grid = $this->increaseCellContent($leftCell->value) . $this->increaseCellContent($rightCell->value);
        }

        if ($grid === '*0') {
            $leftCell = new Cell($firstRow[0], 0);
            $rightCell = new Cell($firstRow[1], 1);
            $grid = $this->increaseCellContent($leftCell->value) . $this->increaseCellContent($rightCell->value);
        }

        return $grid;
    }

    private function increaseCellContent(string|int $cellValue): string|int
    {
        if ($cellValue === '*') return $cellValue;
        return $cellValue + 1;
    }
}
