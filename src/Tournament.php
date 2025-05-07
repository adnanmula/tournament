<?php declare(strict_types=1);

namespace AdnanMula\Tournament;

use AdnanMula\Tournament\Classification\Classification;
use AdnanMula\Tournament\Fixture\Fixtures;
use JsonSerializable;

class Tournament implements JsonSerializable
{
    /**
     * @param array<User> $admins
     * @param array<User> $players
     */
    public function __construct(
        private(set) string $name,
        private(set) string $description,
        private(set) TournamentType $type,
        private(set) array $admins,
        private(set) array $players,
        private(set) \DateTimeImmutable $createdAt,
        private(set) ?\DateTimeImmutable $startedAt,
        private(set) ?\DateTimeImmutable $finishedAt,
        private(set) Fixtures $fixtures,
        private(set) Classification $classification,
    ) {}

    public function adminIds(): array
    {
        return \array_map(static fn (User $u): int|string => $u->id, $this->admins);
    }

    public function playerIds(): array
    {
        return \array_map(static fn (User $u): int|string => $u->id, $this->players);
    }

    public function updateAdmins(User ...$admins): static
    {
        $this->admins = array_values(array_unique($admins));

        return $this;
    }

    public function updatePlayers(User ...$players): static
    {
        $this->players = array_values(array_unique($players));

        return $this;
    }

    public function updateCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function updateStartedAt(?\DateTimeImmutable $startedAt): static
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function updateFinishedAt(?\DateTimeImmutable $finishedAt): static
    {
        $this->finishedAt = $finishedAt;

        if (null !== $this->finishedAt) {
            $this->classification->updateIsFinished(true);
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type->name,
            'admins' => $this->admins,
            'players' => $this->players,
            'createdAt' => $this->createdAt->format('Y-m-d'),
            'startedAt' => $this->startedAt?->format('Y-m-d'),
            'finishedAt' => $this->finishedAt?->format('Y-m-d'),
            'fixtures' => $this->fixtures->jsonSerialize(),
            'classification' => $this->classification->jsonSerialize(),
        ];
    }
}
