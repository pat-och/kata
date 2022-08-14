<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;


class Minesweeper
{
    private Board $board;

    public function __construct(
        string $stringSchemeGrid
    ) {
        $this->board = new Board($stringSchemeGrid);
    }

    public function handle(): string
    {
        return $this->board->getSolvedGrid();
    }
}
