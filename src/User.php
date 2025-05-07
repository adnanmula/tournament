<?php declare(strict_types=1);

namespace AdnanMula\Tournament;

use JsonSerializable;

readonly class User implements JsonSerializable
{
    public function __construct(
        private(set) string|int $id,
        private(set) string $name,
    ) {}

    public function __toString(): string
    {
        return (string) $this->id;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
