<?php declare(strict_types=1);

namespace AdnanMula\Tournament\Classification;

use JsonSerializable;

class Player implements JsonSerializable
{
    public function __construct(
        private(set) int $position,
        private(set) readonly User $user,
        private(set) int $wins = 0,
        private(set) int $losses = 0,
        private(set) int $gameWins = 0,
        private(set) int $gameLosses = 0,
        private(set) int $pointsPositive = 0,
        private(set) int $pointsNegative = 0,
    ) {}

    public function updatePosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function addWin(): self
    {
        $this->wins++;

        return $this;
    }

    public function updateWins(int $value): self
    {
        $this->wins = $value;

        return $this;
    }

    public function addLose(): self
    {
        $this->losses++;

        return $this;
    }

    public function updateLosses(int $value): self
    {
        $this->losses = $value;

        return $this;
    }

    public function addGameWin(): self
    {
        $this->gameWins++;

        return $this;
    }

    public function addGameLoss(): self
    {
        $this->gameLosses++;

        return $this;
    }

    public function updateGameWins(int $value): self
    {
        $this->gameWins = $value;

        return $this;
    }

    public function updateGameLosses(int $value): self
    {
        $this->gameLosses = $value;

        return $this;
    }

    public function addPointsPositive(int $points): self
    {
        $this->pointsPositive += $points;

        return $this;
    }

    public function addPointsNegative(int $points): self
    {
        $this->pointsNegative += $points;

        return $this;
    }

    public function updatePointsPositive(int $value): self
    {
        $this->pointsPositive = $value;

        return $this;
    }

    public function updatePointsNegative(int $value): self
    {
        $this->pointsNegative = $value;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'position' => $this->position,
            'user' => $this->user->jsonSerialize(),
            'wins' => $this->wins,
            'losses' => $this->losses,
            'gameWins' => $this->gameWins,
            'gameLosses' => $this->gameLosses,
            'pointsPositive' => $this->pointsPositive,
            'pointsNegative' => $this->pointsNegative,
        ];
    }
}
