<?php declare(strict_types=1);

namespace AdnanMula\Tournament\Fixture;

use AdnanMula\Tournament\User;
use InvalidArgumentException;
use JsonSerializable;

class Fixture implements JsonSerializable
{
    public function __construct(
        private(set) readonly string $reference,
        private(set) readonly array $players,
        private(set) readonly FixtureType $type,
        private(set) readonly int $position,
        private(set) readonly \DateTimeImmutable $createdAt,
        private(set) ?\DateTimeImmutable $playedAt,
    ) {
        foreach ($this->players as $player) {
            if (false === $player instanceof User) {
                throw new InvalidArgumentException('Players should be an instance of ' . User::class);
            }
        }
    }

    public function playerIds(): array
    {
        return \array_map(static fn (User $u): int|string => $u->id, $this->players);
    }

    public function updatePlayedAt(?\DateTimeImmutable $playedAt): self
    {
        $this->playedAt = $playedAt;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'reference' => $this->reference,
            'players' => array_map(static fn (User $user) => $user->jsonSerialize(), $this->players),
            'type' => $this->type->value,
            'position' => $this->position,
            'createdAt' => $this->createdAt->format('Y-m-d'),
            'playedAt' => $this->playedAt?->format('Y-m-d'),
        ];
    }
}
