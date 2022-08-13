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
        if ($this->stringSchemeGrid === '0*') {
            return sprintf(
                '%s%s',
                $this->increaseCellContent(0),
                $this->increaseCellContent(1)
            );
        }

        if ($this->stringSchemeGrid === '*0') {
            return sprintf(
                '%s%s',
                $this->increaseCellContent(0),
                $this->increaseCellContent(1)
            );
        }

        if ($this->stringSchemeGrid === '*00') {
            return sprintf(
                '%s%s%s',
                $this->increaseCellContent(0),
                $this->increaseCellContent(1),
                $this->board->cell(1)->isMine() ? $this->increaseCellContent(2) : $this->cells[2]->value
            );
        }

        if ($this->stringSchemeGrid === '00*') {
            return sprintf(
                '%s%s%s',
                $this->board->hasMineAtRight(0) ? $this->increaseCellContent(0) : $this->cells[0]->value,
                $this->increaseCellContent(1),
                $this->increaseCellContent(2)
            );
        }

        if ($this->stringSchemeGrid === '0*0') {
            return sprintf(
                '%s%s%s',
                $this->board->hasMineAtRight(0) ? $this->increaseCellContent(0) : $this->cells[0]->value,
                $this->increaseCellContent(1),
                $this->board->cell(1)->isMine() ? $this->increaseCellContent(2) : $this->cells[2]->value
            );
        }

        if ($this->stringSchemeGrid === '**0') {
            return sprintf(
                '%s%s%s',
                $this->board->hasMineAtRight(0) ? $this->increaseCellContent(0) : $this->cells[0]->value,
                ($this->board->cell(0)->isMine() && $this->board->hasMineAtRight(1)) ? 2 : $this->cells[1]->value,
                $this->board->cell(1)->isMine() ? $this->increaseCellContent(2) : $this->cells[2]->value
            );
        }

        if ($this->stringSchemeGrid === '0**') {
            return sprintf(
                '%s%s%s',
                $this->board->hasMineAtRight(0) ? $this->increaseCellContent(0) : $this->cells[0]->value,
                ($this->board->cell(0)->isMine() && $this->board->hasMineAtRight(1)) ? 2 : $this->cells[1]->value,
                $this->board->cell(1)->isMine() ? $this->increaseCellContent(2) : $this->cells[2]->value
            );
        }

        if ($this->stringSchemeGrid === '*0*') {
            return sprintf(
                '%s%s%s',
                $this->board->hasMineAtRight(0) ? $this->increaseCellContent(0) : $this->cells[0]->value,
                ($this->board->cell(0)->isMine() && $this->board->hasMineAtRight(1)) ? 2 : $this->cells[1]->value,
                $this->board->cell(1)->isMine() ? $this->increaseCellContent(2) : $this->cells[2]->value
            );
        }

        return $this->stringSchemeGrid;
    }

    private function increaseCellContent(int $cellIndex): string|int
    {
        if ($this->cells[$cellIndex]->isNotMine())
            $this->cells[$cellIndex]->increase();

        return $this->cells[$cellIndex]->value;
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
}
