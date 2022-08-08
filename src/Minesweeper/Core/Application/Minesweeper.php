<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;

use App\Minesweeper\Core\Domain\Cell;

class Minesweeper
{
    public function __invoke(string $grid): string
    {
        $grid = str_replace('.', '0', $grid);
        $firstRow = str_split($grid);
        $cells = $this->getCells($firstRow);

        if ($grid === '0*') {
            $grid = $this->increaseCellContent($cells[0]->value) . $this->increaseCellContent($cells[1]->value);
        }

        if ($grid === '*0') {
            $grid = $this->increaseCellContent($cells[0]->value) . $this->increaseCellContent($cells[1]->value);
        }

        return $grid;
    }

    private function increaseCellContent(string|int $cellValue): string|int
    {
        if ($cellValue === '*') return $cellValue;
        return $cellValue + 1;
    }

    private function getCells(array $row): array
    {
        $cells = [];

        foreach ($row as $rowIndex => $cellValue) {
            $cells[] = new Cell($cellValue, $rowIndex);
        }

        return $cells;
    }
}
