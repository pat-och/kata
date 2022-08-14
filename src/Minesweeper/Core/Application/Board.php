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

    public function __construct(
        private string $grid,
    ) {
        $this->buildCells();
        $this->resolve();
    }

    private function buildCells(): void
    {
        $rows = explode(self::ROW_SEPARATOR, $this->grid);

        foreach ($rows as $row => $rowAsString) {
            foreach (str_split($rowAsString) as $column => $value) {
                $inverseRow = count($rows) - 1 - $row;
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
            return $this->cells[0]->value . self::ROW_SEPARATOR . $this->cells[1]->value;
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
