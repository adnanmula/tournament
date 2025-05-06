<?php declare(strict_types=1);

namespace AdnanMula\Tournament\Tests;

use AdnanMula\Tournament\Classification\Classification;
use AdnanMula\Tournament\Fixture\Fixtures;
use AdnanMula\Tournament\Fixture\FixturesGenerator;
use AdnanMula\Tournament\Fixture\FixtureType;
use AdnanMula\Tournament\Tournament;
use AdnanMula\Tournament\TournamentType;
use AdnanMula\Tournament\User;
use PHPUnit\Framework\TestCase;

class FixtureGeneratorTest extends TestCase
{
    public function testGenerator(): void
    {
        $generator = new FixturesGenerator();

        $tournament = new Tournament(
            'Test 1',
            '',
            TournamentType::ROUND_ROBIN_2,
            [
                new User(1, '1'),
            ],
            [
                new User(1, '1'),
                new User(2, '2'),
            ],
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            null,
            new Fixtures(FixtureType::BEST_OF_1, 'Round'),
            new Classification(false),
        );

        $generator->execute($tournament);
        $fixtures = $tournament->fixtures;

        self::assertIsArray($fixtures->fixtures[0]->players);
        self::assertIsArray($fixtures->fixtures[1]->players);
        self::assertEquals(0, $fixtures->fixtures[0]->position);
        self::assertEquals(1, $fixtures->fixtures[1]->position);
        self::assertEquals('Round 1', $fixtures->fixtures[0]->reference);
        self::assertEquals('Round 2', $fixtures->fixtures[1]->reference);
    }

    public function testGroupedByReference(): void
    {
        $generator = new FixturesGenerator();

        $tournament = new Tournament(
            'Test 1',
            '',
            TournamentType::ROUND_ROBIN_2,
            [
                new User(1, '1'),
            ],
            [
                new User(1, '1'),
                new User(2, '2'),
                new User(3, '3'),
                new User(4, '4'),
            ],
            new \DateTimeImmutable(),
            new \DateTimeImmutable(),
            null,
            new Fixtures(FixtureType::BEST_OF_1, 'Round'),
            new Classification(false),
        );

        $generator->execute($tournament);
        $groupedFixtures = $tournament->fixtures->groupedByReference();

        self::assertEquals(
            ['Round 1', 'Round 2', 'Round 3', 'Round 4', 'Round 5', 'Round 6'],
            array_keys($groupedFixtures),
        );

        foreach ($groupedFixtures as $round => $fixtures) {
            foreach ($fixtures as $fixture) {
                self::assertEquals($round, $fixture->reference);
            }
        }
    }
}
