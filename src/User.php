<?php declare(strict_types=1);

namespace AdnanMula\Tournament;

class User
{
    public function __construct(
        private(set) string|int $id,
        private(set) string $name,
    ) {}
}
