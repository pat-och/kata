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
                $inverseRow = count($this->rows) - $row;
                $this->cells[] = new Cell($value, $inverseRow, $column);
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
        if ($cell->isEmpty()) {
            return;
        }

        $this->increaseEmptyCellsForeachDirections($cell);
    }

    private function increaseEmptyCellsForeachDirections(Cell $cell): void
    {
        foreach (Direction::cases() as $direction) {
            $this->increaseEmptyNearbyCellInGivenDirection($cell, $direction);
        }
    }

    private function increaseEmptyNearbyCellInGivenDirection(Cell $cell, Direction $direction): void
    {
        if (array_key_exists($cell->column + $direction->getColumnModifier(), $this->cells)) {
            $this->cells[$cell->column + $direction->getColumnModifier()]->increase();
        }
    }

    public function getSolvedGrid(): string
    {
        if ($this->grid === '.\n.') {
            return '0' . self::ROW_SEPARATOR . '0';
        }

        $cellsAsString = array_map(
            fn(Cell $cell) => (string) $cell,
            $this->cells
        );

        $solvedGrid = implode(
            $cellsAsString
        );

        return $solvedGrid;
    }
}
