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

    public function getRevealedBoard(): string
    {
        return (string) $this->board;
    }
}
