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

    /** @test */
    public function shouldComputeNoCellGrid()
    {
        $this->assertEquals('', $this->resolve(''));
    }

    /** @test */
    public function shouldComputeOneCellGridWithMine()
    {
        $this->assertEquals('*', $this->resolve('*'));
    }


    /** @test */
    public function shouldComputeOneEmptyCellGrid()
    {
        $this->assertEquals('0', $this->resolve('.'));
    }

    private function resolve(string $grid): string
    {
        return ($this->minesweeper)($grid);
    }

    /** @test */
    public function shouldComputeOneRowOfTwoCellGridFullOfMines()
    {
        $this->assertEquals('**', $this->resolve('**'));
    }


    /** @test */
    public function shouldComputeOneRowOfTwoCellGridWithNoMines()
    {
        $this->assertEquals('00', $this->resolve('..'));
    }
}

