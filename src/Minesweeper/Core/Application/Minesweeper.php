<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;

use App\Minesweeper\Core\Domain\Cell;

class Minesweeper
{
    /** @var Cell[]  */
    private array $cells;

    public function __construct(
        private string $grid
    ) {
    }

    public function handle(): string
    {
        $this->grid = str_replace('.', '0', $this->grid);
        $firstRow = str_split($this->grid);

        $this->cells = $this->buildCells($firstRow);

        if ($this->grid === '0*') {
            $this->grid = $this->increaseCellContent(0) . $this->increaseCellContent(1);
        }

        if ($this->grid === '*0') {
            $this->grid = $this->increaseCellContent(0) . $this->increaseCellContent(1);
        }

        if ($this->grid === '*00') {
            $this->grid = sprintf(
                '%s%s%s',
                $this->increaseCellContent(0),
                $this->increaseCellContent(1),
                $this->cells[1]->value === '*' ? $this->increaseCellContent(2) : $this->cells[2]->value
            );
        }

        if ($this->grid === '00*') {
            $this->grid = sprintf(
                '%s%s%s',
                $this->cells[1]->value === '*' ? $this->increaseCellContent(0) : $this->cells[0]->value,
                $this->increaseCellContent(1),
                $this->increaseCellContent(2)
            );
        }

        if ($this->grid === '0*0') {
            $this->grid = sprintf(
                '%s%s%s',
                $this->cells[1]->value === '*' ? $this->increaseCellContent(0) : $this->cells[0]->value,
                $this->increaseCellContent(1),
                $this->cells[1]->value === '*' ? $this->increaseCellContent(2) : $this->cells[2]->value
            );
        }

        if ($this->grid === '**0') {
            $this->grid = sprintf(
                '%s%s%s',
                $this->increaseCellContent(0),
                $this->increaseCellContent(1),
                $this->cells[1]->value === '*' ? $this->increaseCellContent(2) : $this->cells[2]->value
            );
        }

        if ($this->grid === '0**') {
            $this->grid = sprintf(
                '%s%s%s',
                $this->increaseCellContent(0),
                $this->increaseCellContent(1),
                $this->cells[1]->value === '*' ? $this->increaseCellContent(2) : $this->cells[2]->value
            );
        }

        if ($this->grid === '*0*') {
            $this->grid = sprintf(
                '%s%s%s',
                $this->increaseCellContent(0),
                ($this->cells[0]->value === '*' && $this->cells[2]->value === '*') ? 2 : $this->cells[2]->value,
                $this->cells[1]->value === '*' ? $this->increaseCellContent(2) : $this->cells[2]->value
            );
        }

        return $this->grid;
    }

    private function increaseCellContent(int $cellIndex): string|int
    {
        $cell = $this->cells[$cellIndex];

        if ($cell->isMine())
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
