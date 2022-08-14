<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;

use App\Minesweeper\Core\Domain\Cell;
use App\Minesweeper\Core\Domain\Direction;

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
        foreach($this->cells as $cell) {
            $this->increaseNearbyCellsIfCellIsMine($cell);
        }
    }

    private function increaseNearbyCellsIfCellIsMine(Cell $cell): void
    {
        if ($cell->isEmpty()) return;
        $this->increaseLeftAndRightEmptyCells($cell);
    }

    private function increaseLeftAndRightEmptyCells(Cell $cell): void
    {
        $this->increaseEmptyRightCell($cell, Direction::RIGHT);
        $this->increaseEmptyLeftCell($cell, Direction::LEFT);
    }

    private function increaseEmptyRightCell(Cell $cell, Direction $direction): void
    {
        if (array_key_exists($cell->column + $direction->getColumnModifier(), $this->cells))
            $this->cells[$cell->column + $direction->getColumnModifier()]->increase();
    }

    private function increaseEmptyLeftCell(Cell $cell, Direction $direction): void
    {
        if (array_key_exists($cell->column + $direction->getColumnModifier(), $this->cells)) {
            $this->cells[$cell->column + $direction->getColumnModifier()]->increase();
        }
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
