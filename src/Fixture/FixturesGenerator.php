<?php declare(strict_types=1);

namespace AdnanMula\Tournament\Fixture;

use AdnanMula\Tournament\Tournament;
use AdnanMula\Tournament\TournamentType;

final class FixturesGenerator
{
    public function execute(Tournament $tournament): array
    {
        $fixtures = $this->generateFixtures($tournament);

        if ($tournament->type === TournamentType::ROUND_ROBIN_2) {
            $secondHalfFixtures = $this->reverseFixtures($tournament, $fixtures);
            $fixtures = \array_merge($fixtures, $secondHalfFixtures);
        }

        if ($tournament->type === TournamentType::ROUND_ROBIN_3) {
            $secondHalfFixtures = $this->reverseFixtures($tournament, $fixtures);
            $thirdHalfFixtures = $this->reverseFixtures($tournament, $secondHalfFixtures);
            $fixtures = \array_merge($fixtures, $secondHalfFixtures, $thirdHalfFixtures);
        }

        if ($tournament->type === TournamentType::ROUND_ROBIN_4) {
            $secondHalfFixtures = $this->reverseFixtures($tournament, $fixtures);
            $thirdHalfFixtures = $this->reverseFixtures($tournament, $secondHalfFixtures);
            $fourthHalfFixtures = $this->reverseFixtures($tournament, $thirdHalfFixtures);
            $fixtures = \array_merge($fixtures, $secondHalfFixtures, $thirdHalfFixtures, $fourthHalfFixtures);
        }

        $tournament->fixtures->add(...$fixtures);

        return $fixtures;
    }

    /** @return array<Fixture> */
    private function generateFixtures(Tournament $tournament): array
    {
        $players = $tournament->players;

        \shuffle($players);

        if (\count($players) % 2 !== 0) {
            $players[] = null;
        }

        $fixtures = [];
        $halfCount = \count($players) / 2;
        $position = 0;

        for ($i = 0; $i < \count($players) - 1; $i++) {
            for ($j = 0; $j <= $halfCount - 1; $j++) {
                $player1 = $players[$j];
                $player2 = $players[\count($players) - $j - 1];

                if (null === $player1 || null === $player2) {
                    continue;
                }

                $fixtures[] = new Fixture(
                    $tournament->fixtures->reference . ' ' . ($i + 1),
                    [$player1, $player2],
                    $tournament->fixtures->type,
                    $position,
                    new \DateTimeImmutable(),
                    null,
                );

                $position++;
            }

            $players = $this->rotate($players);
        }

        return $fixtures;
    }

    private function rotate(array $players): array
    {
        $firstPlayer = $players[0];
        unset($players[0]);

        $lastPlayer = \array_pop($players);

        return [$firstPlayer, $lastPlayer, ...$players];
    }

    /** @return array<Fixture> */
    private function reverseFixtures(Tournament $tournament, array $fixtures): array
    {
        /** @var Fixture $lastFixture */
        $lastFixture = \end($fixtures);
        $position = $lastFixture->position + 1;

        $referenceParts = \explode(' ', \trim($lastFixture->reference));
        $reference = (int) \end($referenceParts) + 1;

        $secondHalfFixtures = [];
        $count = 0;

        /** @var Fixture $fixture */
        foreach ($fixtures as $fixture) {
            $secondHalfFixtures[] = new Fixture(
                $tournament->fixtures->reference . ' ' . $reference,
                \array_reverse($fixture->players),
                $fixture->type,
                $position,
                new \DateTimeImmutable(),
                null,
            );

            $count++;

            $halfCount = \count($tournament->players) % 2 === 0
                ? \ceil(\count($tournament->players) / 2)
                : \ceil(\count($tournament->players) / 2) - 1;

            if ($count >= $halfCount) {
                $reference++;
                $count = 0;
            }

            $position++;
        }

        return $secondHalfFixtures;
    }
}
