<?php declare(strict_types=1);

namespace AdnanMula\Tournament\Tests;

use AdnanMula\Tournament\Classification\Classification;
use AdnanMula\Tournament\Classification\Player;
use AdnanMula\Tournament\User;
use PHPUnit\Framework\TestCase;

class ClassificationTest extends TestCase
{
    public function testClassification(): void
    {
        $player1 = new Player(1, new User(1, '1'), 0, 10, 0, 0, 0, 0);
        $player2 = new Player(2, new User(2, '2'), 10, 0, 0, 0, 0, 0);
        $player3 = new Player(3, new User(3, '3'), 5, 5, 0, 0, 0, 0);
        $player4 = new Player(4, new User(4, '4'), 2, 8, 0, 0, 0, 0);

        $classification = new Classification(true, $player1, $player2, $player3, $player4);
        $podium = $classification->podium();

        self::assertEquals(1, $podium[0]->position);
        self::assertEquals(2, $podium[1]->position);
        self::assertEquals(3, $podium[2]->position);

        self::assertEquals(2, $podium[0]->user->id);
        self::assertEquals(3, $podium[1]->user->id);
        self::assertEquals(4, $podium[2]->user->id);
    }
}
