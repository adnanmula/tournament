<?php declare(strict_types=1);

namespace AdnanMula\Tournament\Classification;

use JsonSerializable;

class User implements JsonSerializable
{
    public function __construct(
        private(set) string|int $id,
        private(set) string $name,
    ) {}

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
