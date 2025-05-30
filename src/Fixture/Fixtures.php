<?php declare(strict_types=1);

namespace AdnanMula\Tournament\Fixture;

use JsonSerializable;

class Fixtures implements JsonSerializable
{
    private(set) array $fixtures;

    public function __construct(
        private(set) FixtureType $type,
        private(set) string $reference,
        Fixture ...$fixtures,
    ) {
        $this->fixtures = $fixtures;
    }

    /** @return array<string, array<Fixture>> */
    public function groupedByReference(): array
    {
        $grouped = [];

        foreach ($this->fixtures as $fixture) {
            $grouped[$fixture->reference][] = $fixture;
        }

        uasort($grouped, static function (array $a, array $b) {
            $minA = min(array_map(static fn (Fixture $f) => $f->position, $a));
            $minB = min(array_map(static fn (Fixture $f) => $f->position, $b));

            return $minA <=> $minB;
        });

        return $grouped;
    }

    public function add(Fixture ...$fixtures): self
    {
        array_push($this->fixtures, ...$fixtures);

        return $this;
    }

    public function empty(): self
    {
        $this->fixtures = [];

        return $this;
    }

    public function updateType(FixtureType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function updateReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'reference' => $this->reference,
            'type' => $this->type->value,
            'fixtures' => array_map(static fn (Fixture $fixture) => $fixture->jsonSerialize(), $this->fixtures),
        ];
    }
}
