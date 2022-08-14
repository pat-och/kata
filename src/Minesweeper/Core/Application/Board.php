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

    /** @return Cell[] */
    private function buildCells(): void
    {
        $rows = explode(self::ROW_SEPARATOR, $this->grid);

        foreach ($rows as $row => $rowAsString) {
            foreach (str_split($rowAsString) as $column => $value) {
                $this->cells[] = new Cell($value, $row, $column);
            }
        }
    }

    private function resolve(): void
    {
        for ($column = 0; $column < strlen($this->grid); ++$column) {
            $this->increaseNearbyCellsIfCellIsMine($column);
        }
    }

    private function increaseNearbyCellsIfCellIsMine(int $column): void
    {
        if ($this->cells[$column]->isEmpty()) return;
        $this->increaseLeftAndRightEmptyCells($column);
    }

    private function increaseLeftAndRightEmptyCells(int $column): void
    {
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
