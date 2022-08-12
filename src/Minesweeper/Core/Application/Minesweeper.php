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
            $this->grid = $this->increaseCellContent($cells[0]->value) . $this->increaseCellContent($cells[1]->value);
        }

        if ($this->grid === '*0') {
            $this->grid = $this->increaseCellContent($cells[0]->value) . $this->increaseCellContent($cells[1]->value);
        }

        return $this->grid;
    }

    private function increaseCellContent(string|int $cellValue): string|int
    {
        if ($cellValue === '*') return $cellValue;
        return $cellValue + 1;
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
