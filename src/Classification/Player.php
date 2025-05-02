<?php declare(strict_types=1);

namespace AdnanMula\Tournament;

class Player
{
    public function __construct(
        private(set) int $position,
        private(set) User $user,
        private(set) int $wins,
        private(set) int $losses,
        private(set) int $gameWins,
        private(set) int $gameLosses,
        private(set) int $pointsPossitive,
        private(set) int $pointsNegative,
    ) {}
}
