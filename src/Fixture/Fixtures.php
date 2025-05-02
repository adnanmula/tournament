<?php declare(strict_types=1);

namespace AdnanMula\Tournament\Fixture;

use JsonSerializable;

class Fixtures implements JsonSerializable
{
    private(set) array $fixtures;

    public function __construct(
        private(set) readonly FixtureType $type,
        private(set) readonly string $reference,
        Fixture ...$fixtures,
    ) {
        $this->fixtures = $fixtures;
    }

    public function add(Fixture ...$fixtures): self
    {
        array_push($this->fixtures, ...$fixtures);

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
