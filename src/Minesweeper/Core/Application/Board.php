<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;

use App\Minesweeper\Core\Domain\Cell;

class Board
{
    /** @var Cell[] */
    private array $cells = [];

    public function __construct(Cell ...$cells)
    {
        $this->cells = $cells;
    }

    public function cell(int $i): Cell
    {
        return $this->cells[$i];
    }

    public function hasMineAtRight(int $i): bool
    {
        if (!array_key_exists($i + 1, $this->cells))
            return false;

        return $this->cells[$i + 1]->isMine();
    }
}
