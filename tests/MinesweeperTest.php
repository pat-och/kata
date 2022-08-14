<?php

declare(strict_types=1);


namespace App\Tests;

use App\Minesweeper\Core\Application\Minesweeper;
use PHPUnit\Framework\TestCase;

class MinesweeperTest extends TestCase
{
    private Minesweeper $minesweeper;

    protected function setUp(): void
    {

    }

    /**
     * @test
     * @dataProvider cases
     */
    public function ShouldComputeMinesweeperGrid(
        string $case,
        string $input,
        string $expected,
    ) {
        $this->assertEquals($expected, $this->resolve($input), $case);
    }

    private function cases(): array
    {
        return [
            ['no cells', '', ''],
            ['one cell with mine', '*', '*'],
            ['one empty cell', '.', '0'],
            //
            ['one row of two cells full of mines', '**', '**'],
            ['one row of two empty cells', '..', '00'],
            ['one row of two cells with mine in the first one', '*.', '*1'],
            ['one row of two cells with mine in the last one', '.*', '1*'],
            //
            ['one row of three cells with mine  at first', '*..', '*10'],
            ['one row of three cells with mine in the last one', '..*', '01*'],
            ['one row of three cells with mine in the middle', '.*.', '1*1'],
            ['one row of three cells with two mines at first', '**.', '**1'],
            ['one row of three cells with two mines at least', '.**', '1**'],
            ['one row of three cells full of mines', '***', '***'],
            ['one row of three cells with two mines on borders', '*.*', '*2*'],
            //
            ['one row of four empty cells ', '....', '0000'],
            ['one row of four cells with full of mines', '****', '****'],
        ];
    }

    private function resolve(string $grid): string
    {
        $this->minesweeper = new Minesweeper($grid);
        return $this->minesweeper->getSolvedGrid();
    }
}

