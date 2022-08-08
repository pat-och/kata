<?php

declare(strict_types=1);


namespace App\Tests;

use App\Minesweeper\Core\Application\Minesweeper;
use PHPUnit\Framework\TestCase;

class MinesweeperTest extends TestCase
{
    /** @test */
    public function shouldComputeAnEmptyGrid()
    {
        $minesweeper = new Minesweeper();
        $this->assertEquals('', $minesweeper(''));
    }

    /** @test */
    public function shouldComputeOneCellGridWithMine()
    {
        $minesweeper = new Minesweeper();
        $this->assertEquals('*', $minesweeper('*'));
    }
}

