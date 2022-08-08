<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;

class Minesweeper
{
    public function __invoke(string $grid): string
    {
        if ($grid === '.') return '0';

        return $grid;
    }
}
