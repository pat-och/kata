<?php declare(strict_types=1);


namespace App\Minesweeper\Core\Domain;

enum Direction: string
{
    case RIGHT = '1';
    case LEFT = '-1';

    public function getValue(): int
    {
        return (int) $this->value;
    }
}
