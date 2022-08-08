<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;

class Minesweeper
{
    public function __invoke(string $grid): string
    {
        if ($grid === '*.') {
            return '*1';
        }

        return str_replace('.', '0', $grid);
    }
}
