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
    public function shouldComputeAnEmptyGrid()
    {
        $this->assertEquals('', ($this->minesweeper)(''));
    }

    /** @test */
    public function shouldComputeOneCellGridWithMine()
    {
        $this->assertEquals('*', ($this->minesweeper)('*'));
    }


    /** @test */
    public function shouldComputeOneEmptyCellGrid()
    {
        $this->assertEquals('0', ($this->minesweeper)('.'));
    }
}

