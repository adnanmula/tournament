<?php declare(strict_types=1);

namespace AdnanMula\Tournament;

use AdnanMula\Tournament\Fixture\Fixtures;
use JsonSerializable;

class Tournament implements JsonSerializable
{
    public function __construct(
        private(set) string $name,
        private(set) string $description,
        private(set) TournamentType $type,
        private(set) array $admins,
        private(set) array $players,
        private(set) ?\DateTimeImmutable $createdAt,
        private(set) ?\DateTimeImmutable $startedAt,
        private(set) ?\DateTimeImmutable $finishedAt,
        private(set) Fixtures $fixtures,
        private(set) Classification $classification,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type->name,
            'admins' => $this->admins,
            'players' => $this->players,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'startedAt' => $this->startedAt->format('Y-m-d H:i:s'),
            'finishedAt' => $this->finishedAt->format('Y-m-d H:i:s'),
            'fixtures' => $this->fixtures->jsonSerialize(),
            'classification' => $this->classification->jsonSerialize(),
        ];
    }
}
