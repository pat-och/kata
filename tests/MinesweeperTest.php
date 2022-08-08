<?php

declare(strict_types=1);


namespace App\Tests;

use PHPUnit\Framework\TestCase;

class MinesweeperTest extends TestCase
{
    /** @test */
    public function shouldComputeAnEmptyGrid()
    {
        $this->assertTrue('' === $minesweeper(''));
    }
}

