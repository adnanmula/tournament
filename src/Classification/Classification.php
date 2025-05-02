<?php declare(strict_types=1);

namespace AdnanMula\Tournament;

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

    private function order(): void
    {
        $players = $this->players;

        \usort($players, static function (Player $a, Player $b) {
            if ($b->wins === $a->wins && $a->losses === $b->losses) {
                $aDiff = $a->pointsPossitive - $a->pointsNegative;
                $bDiff = $b->pointsPossitive - $b->pointsNegative;

                if ($aDiff === $bDiff) {
                    if ($a->pointsPossitive === $b->pointsPossitive) {
                        return $a->pointsNegative <=> $b->pointsNegative;
                    }

                    return $b->pointsPossitive <=> $a->pointsPossitive;
                }

                return $bDiff <=> $aDiff;
            }

            if ($b->wins === $a->wins) {
                return $a->losses <=> $b->losses;
            }

            return $b->wins <=> $a->wins;
        });

        foreach ($players as $index => $player) {
            $player->setPosition($index + 1);
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
