<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;

use App\Minesweeper\Core\Domain\Cell;

class Minesweeper
{
    public function __construct(
        private string $grid
    ) {
    }

    public function handle(): string
    {
        $this->grid = str_replace('.', '0', $this->grid);
        $firstRow = str_split($this->grid);

        $cells = $this->buildCells($firstRow);

        if ($this->grid === '0*') {
            $this->grid = $this->increaseCellContent($cells[0]) . $this->increaseCellContent($cells[1]);
        }

        if ($this->grid === '*0') {
            $this->grid = $this->increaseCellContent($cells[0]) . $this->increaseCellContent($cells[1]);
        }

        if ($this->grid === '*00') {
            $this->grid = sprintf(
                '%s%s%s',
                $this->increaseCellContent($cells[0]),
                $this->increaseCellContent($cells[1]),
                $cells[1]->value === '*' ? $this->increaseCellContent($cells[2]) : $cells[2]->value
            );
        }

        if ($this->grid === '00*') {
            $this->grid = sprintf(
                '%s%s%s',
                $cells[1]->value === '*' ? $this->increaseCellContent($cells[0]) : $cells[0]->value,
                $this->increaseCellContent($cells[1]),
                $this->increaseCellContent($cells[2])
            );
        }

        if ($this->grid === '0*0') {
            $this->grid = sprintf(
                '%s%s%s',
                $cells[1]->value === '*' ? $this->increaseCellContent($cells[0]) : $cells[0]->value,
                $this->increaseCellContent($cells[1]),
                $cells[1]->value === '*' ? $this->increaseCellContent($cells[2]) : $cells[2]->value
            );
        }

        if ($this->grid === '**0') {
            $this->grid = sprintf(
                '%s%s%s',
                $this->increaseCellContent($cells[0]),
                $this->increaseCellContent($cells[1]),
                $cells[1]->value === '*' ? $this->increaseCellContent($cells[2]) : $cells[2]->value
            );
        }

        if ($this->grid === '0**') {
            $this->grid = sprintf(
                '%s%s%s',
                $this->increaseCellContent($cells[0]),
                $this->increaseCellContent($cells[1]),
                $cells[1]->value === '*' ? $this->increaseCellContent($cells[2]) : $cells[2]->value
            );
        }

        if ($this->grid === '*0*') {
            $this->grid = sprintf(
                '%s%s%s',
                $this->increaseCellContent($cells[0]),
                ($cells[0]->value === '*' && $cells[2]->value === '*') ? 2 : $cells[2]->value,
                $cells[1]->value === '*' ? $this->increaseCellContent($cells[2]) : $cells[2]->value
            );
        }

        return $this->grid;
    }

    private function increaseCellContent(Cell $cell): string|int
    {
        if ($cell->value === '*')
            return $cell->value;

        return $cell->value + 1;
    }

    private function buildCells(array $row): array
    {
        $cells = [];

        foreach ($row as $rowIndex => $cellValue) {
            $cells[] = new Cell($cellValue, $rowIndex);
        }

        return $cells;
    }
}
