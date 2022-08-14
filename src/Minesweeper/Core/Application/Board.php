<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;

use App\Minesweeper\Core\Domain\Cell;

class Board
{
    /** @var Cell[] */
    private array $cells = [];

    /** @var string[] */
    private array $rows;

    public function __construct(
        private string $grid,
    ) {
        $this->replaceDotByZeroInGridAsString();

        $this->rows = explode('\n', $this->grid);
        $this->buildCells();

        for ($column = 0; $column < strlen($grid); ++$column) {
            $this->increaseNearbyCellsIfCellIsMine($column);
        }
    }

    public function cell(int $column): Cell
    {
        return $this->cells[$column];
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
        foreach ($this->rows as $row => $rowAsString) {
            foreach (str_split($rowAsString) as $column => $value) {
                $this->cells[] = new Cell($value, $row, $column);
            }
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
