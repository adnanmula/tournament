<?php declare(strict_types=1);

namespace AdnanMula\Tournament\Fixture;

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
    ) {}

    public function updatePlayedAt(?\DateTimeImmutable $playedAt): self
    {
        $this->playedAt = $playedAt;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'reference' => $this->reference,
            'players' => $this->players,
            'type' => $this->type->value,
            'position' => $this->position,
            'createdAt' => $this->createdAt->format('Y-m-d'),
            'playedAt' => $this->playedAt?->format('Y-m-d'),
        ];
    }
}
