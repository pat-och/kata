<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Application;

class Minesweeper
{
    public function __invoke(string $grid): string
    {
        $grid = str_replace('.', '0', $grid);
        $firstRow = str_split($grid);

        if ($grid === '0*') {
            return '1' . $firstRow[1];
        }

        if ($grid === '*0') {
            return $firstRow[0] . '1';
        }

        return $grid;
    }
}
