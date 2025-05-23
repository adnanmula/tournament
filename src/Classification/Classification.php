<?php declare(strict_types=1);

namespace AdnanMula\Tournament\Classification;

use JsonSerializable;

class Classification implements JsonSerializable
{
    private(set) array $players;

    public function __construct(
        private(set) bool $isFinished,
        Player ...$players,
    ) {
        $this->players = $players;
        $this->order();
    }

    public function playerWithId(int|string $id): ?Player
    {
        return array_find($this->players, static fn (Player $player) => $player->user->id === $id);
    }

    public function winner(): ?Player
    {
        if (false === $this->isFinished) {
            return null;
        }

        return $this->at(1);
    }

    public function podium(): array
    {
        if (false === $this->isFinished) {
            return [];
        }

        return [
            $this->at(1),
            $this->at(2),
            $this->at(3),
        ];
    }

    public function at(int $position): ?Player
    {
        return array_find($this->players, static fn (Player $p): bool => $position === $p->position);
    }

    public function addPlayer(Player $player): void
    {
        $this->players[] = $player;
        $this->order();
    }

    public function updateIsFinished(bool $value): self
    {
        $this->isFinished = $value;

        return $this;
    }

    public function order(): void
    {
        $players = $this->players;

        \usort($players, static function (Player $a, Player $b) {
            if ($b->wins === $a->wins && $a->losses === $b->losses) {
                $aDiff = $a->pointsPositive - $a->pointsNegative;
                $bDiff = $b->pointsPositive - $b->pointsNegative;

                if ($aDiff === $bDiff) {
                    if ($a->pointsPositive === $b->pointsPositive) {
                        return $a->pointsNegative <=> $b->pointsNegative;
                    }

                    return $b->pointsPositive <=> $a->pointsPositive;
                }

                return $bDiff <=> $aDiff;
            }

            if ($b->wins === $a->wins) {
                return $a->losses <=> $b->losses;
            }

            return $b->wins <=> $a->wins;
        });

        foreach ($players as $index => $player) {
            $player->updatePosition($index + 1);
        }

        $this->players = $players;
    }

    public function jsonSerialize(): array
    {
        return [
            'isFinished' => $this->isFinished,
            'players' => array_map(static fn (Player $player) => $player->jsonSerialize(), $this->players),
        ];
    }
}
