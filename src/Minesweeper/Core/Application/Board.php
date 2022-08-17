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
    private int $numberOfRows;

    public function __construct(
        private string $grid,
    ) {
        $this->buildCells();
        $this->computeNumberOfNearbyMinesForeachEmptyCell();
    }

    private function buildCells(): void
    {
        $rows = explode(self::ROW_SEPARATOR, $this->grid);
        $this->numberOfRows = count($rows);

        foreach ($rows as $row => $rowAsString) {
            foreach (str_split($rowAsString) as $column => $value) {
                $this->cells[] = new Cell($value, $row, $column);
            }
        }
    }

    private function computeNumberOfNearbyMinesForeachEmptyCell(): void
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

    public function getComputedGrid(): string
    {
        $computedGrid = '';

        $rows = $this->getRows();
        foreach ($rows as $i => $row) {
            if ($i > 0) $computedGrid .= self::ROW_SEPARATOR;
            $computedGrid .= implode($row);
        }

        return $computedGrid;
    }

    private function getRows(): array
    {
        $rows = [];
        for ($i = 0; $i < $this->numberOfRows; $i++) {
            $rows[] = $this->getRow($i);
        }

        return $rows;
    }

    /** @return Cell[] */
    private function getRow(int $index): array
    {
        return array_filter(
            $this->cells,
            fn (Cell $cell) => $cell->row === $index
        );
    }
}
