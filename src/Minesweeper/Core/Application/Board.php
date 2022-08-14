<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;

use App\Minesweeper\Core\Domain\Cell;

class Board
{
    /** @var Cell[] */
    private array $cells = [];

    public function __construct(
        private string $grid,
    ) {
        $this->replaceDotByZeroInGridAsString();
        $this->buildCells();
        for ($i = 0; $i < strlen($grid); ++$i) {
            $this->increaseNearbyCellsIfCellIsMine($i);
        }
    }

    public function cell(int $i): Cell
    {
        return $this->cells[$i];
    }

    public function getSolvedGrid(): string
    {
        return implode(
            array_map(
                fn (Cell $cell) => (string) $cell,
                $this->cells
            )
        );
    }

    /** @return Cell[] */
    public function cells(): array
    {
        return $this->cells;
    }

    /** @return Cell[] */
    private function buildCells(): array
    {
        $row = str_split($this->grid);

        foreach ($row as $rowIndex => $cellValue) {
            $this->cells[] = new Cell($cellValue, $rowIndex);
        }

        return $this->cells;
    }

    private function replaceDotByZeroInGridAsString(): void
    {
        $this->grid = str_replace('.', '0', $this->grid);
    }

    private function increaseNearbyCellsIfCellIsMine(int $column): void
    {
        if ($this->cells[$column]->isEmpty()) return;
        $this->increaseEmptyRightCell($column);
        $this->increaseEmptyLeftCell($column);
    }

    private function increaseEmptyRightCell(int $column): void
    {
        if (array_key_exists($column + 1, $this->cells))
            $this->cells[$column + 1]->increase();
    }

    private function increaseEmptyLeftCell(int $column): void
    {
        if (array_key_exists($column - 1, $this->cells))
            $this->cells[$column - 1]->increase();
    }
}
