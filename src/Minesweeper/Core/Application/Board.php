<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;

use App\Minesweeper\Core\Domain\Cell;

class Board
{
    /** @var string */
    const ROW_SEPARATOR = '\n';

    /** @var Cell[] */
    private array $cells = [];

    /** @var string[] */
    private array $rows;

    public function __construct(
        private string $grid,
    ) {
        $this->buildCells();
        $this->resolve();
    }

    private function buildCells(): void
    {
        $this->rows = explode(self::ROW_SEPARATOR, $this->grid);

        foreach ($this->rows as $row => $rowAsString) {
            foreach (str_split($rowAsString) as $column => $value) {
                $this->cells[] = new Cell($value, $row, $column);
            }
        }
    }

    private function resolve(): void
    {
        foreach($this->rows as $row => $rowAsString) {
            for ($column = 0; $column < strlen($this->grid); ++$column) {
                $this->increaseNearbyCellsIfCellIsMine($row, $column);
            }
        }
    }

    private function increaseNearbyCellsIfCellIsMine(int $row, int $column): void
    {
        if ($this->cells[$column]->isEmpty()) return;
        $this->increaseLeftAndRightEmptyCells($row, $column);
    }

    private function increaseLeftAndRightEmptyCells(int $row, int $column): void
    {
        $this->increaseEmptyRightCell($row, $column);
        $this->increaseEmptyLeftCell($row, $column);
    }

    private function increaseEmptyRightCell(int $row, int $column): void
    {
        if (array_key_exists($column + 1, $this->cells))
            $this->cells[$column + 1]->increase();
    }

    private function increaseEmptyLeftCell(int $row, int $column): void
    {
        if (array_key_exists($column - 1, $this->cells))
            $this->cells[$column - 1]->increase();
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
}
