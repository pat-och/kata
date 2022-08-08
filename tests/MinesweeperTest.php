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
        $this->minesweeper = new Minesweeper();
    }

    /**
     * @test
     * @dataProvider cases
     */
    public function ShouldComputeMinesweeperGrid(
        string $case,
        string $input,
        string $expected,
    )
    {
        $this->assertEquals($expected, $this->resolve($input), $case);
    }

    private function cases(): array
    {
        return [
            ['no cells', '', ''],
            ['one cell with mine', '*', '*'],
            ['one empty cell', '.', '0'],
            ['one row of two cells full of mines', '**', '**'],
            ['one row of two empty cells', '..', '00'],
            ['one row of two cells with mine in the first one', '*.', '*1'],
        ];
    }

    private function resolve(string $grid): string
    {
        return ($this->minesweeper)($grid);
    }
}

