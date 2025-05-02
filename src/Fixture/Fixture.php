<?php declare(strict_types=1);

namespace AdnanMula\Tournament\Fixture;

use JsonSerializable;

class Fixture implements JsonSerializable
{
    public function __construct(
        private(set) readonly string $reference,
        private(set) readonly array $users,
        private(set) readonly FixtureType $type,
        private(set) readonly int $position,
        private(set) readonly \DateTimeImmutable $createdAt,
        private(set) ?\DateTimeImmutable $playedAt,
    ) {}

    public function updatedPlayedAt(?\DateTimeImmutable $playedAt): self
    {
        $this->playedAt = $playedAt;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'reference' => $this->reference,
            'users' => $this->users,
            'type' => $this->type->value,
            'position' => $this->position,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'playedAt' => $this->playedAt?->format('Y-m-d H:i:s'),
        ];
    }
}
