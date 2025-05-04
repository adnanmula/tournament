<?php declare(strict_types=1);

namespace AdnanMula\Tournament;

enum TournamentType: string
{
    case ROUND_ROBIN_1 = 'ROUND_ROBIN_1';
    case ROUND_ROBIN_2 = 'ROUND_ROBIN_2';
    case ROUND_ROBIN_3 = 'ROUND_ROBIN_3';
    case ROUND_ROBIN_4 = 'ROUND_ROBIN_4';
    case ELIMINATION = 'ELIMINATION';
    case ROUND_ROBIN_1_ELIMINATION = 'ROUND_ROBIN_1_ELIMINATION';
    case ROUND_ROBIN_2_ELIMINATION = 'ROUND_ROBIN_2_ELIMINATION';

    public function isRoundRobin(): bool
    {
        return $this === self::ROUND_ROBIN_1
            || $this === self::ROUND_ROBIN_2
            || $this === self::ROUND_ROBIN_3
            || $this === self::ROUND_ROBIN_4;
    }
}
