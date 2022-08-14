<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;

use App\Minesweeper\Core\Domain\Cell;
use JetBrains\PhpStorm\Pure;

class Minesweeper
{
    /** @var Cell[]  */
    private array $cells = [];
    private Board $board;

    public function __construct(
        private string $stringSchemeGrid
    ) {
        $this->replaceDotByZeroInGridAsString();
        $cells = $this->buildCells();
        $this->board = new Board(...$cells);
    }

    public function handle(): string
    {
        for ($i = 0; $i < strlen($this->stringSchemeGrid); ++$i) {
            $this->increaseNearbyCellsIfCellIsMine($i);
        }
        return $this->board->solved();
    }

    private function increaseNearbyCellsIfCellIsMine(int $column): void
    {
        if ($this->cells[$column]->isEmpty()) return;
        $this->increaseEmptyRightCell($column);
        $this->increaseEmptyLeftCell($column);
    }

    /**
     * @return Cell[]
     */
    private function buildCells(): array
    {
        $row = str_split($this->stringSchemeGrid);

        foreach ($row as $rowIndex => $cellValue) {
            $this->cells[] = new Cell($cellValue, $rowIndex);
        }

        return $this->cells;
    }

    private function replaceDotByZeroInGridAsString(): void
    {
        $this->stringSchemeGrid = str_replace('.', '0', $this->stringSchemeGrid);
    }

    private function increaseEmptyRightCell(int $column): void
    {
        if (array_key_exists($column + 1, $this->cells) && $this->cells[$column + 1]->isEmpty())
            $this->cells[$column + 1]->increase();
    }

    private function increaseEmptyLeftCell(int $column): void
    {
        if (array_key_exists($column - 1, $this->cells) && $this->cells[$column - 1]->isEmpty())
            $this->cells[$column - 1]->increase();
    }
}
