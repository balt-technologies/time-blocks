<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use TimeBlocks\TimeSpan;
use Carbon\CarbonImmutable;

class TimeSpanTest extends TestCase
{
    /** @dataProvider inBetweenDataProvider */
    public function testBetween(string $start, string $end, string $testStart, string $testEnd, bool $assertion)
    {
        $startDate = CarbonImmutable::parse($start);
        $endDate = CarbonImmutable::parse($end);

        $testStartDate = CarbonImmutable::parse($testStart);
        $testEndDate = CarbonImmutable::parse($testEnd);

        $timeSpan = new TimeSpan($startDate, $endDate);

        self::assertEquals($assertion, $timeSpan->between($testStartDate, $testEndDate));
    }

    public function inBetweenDataProvider() : array {
        return [
            [
                '2020-10-10 06:00',
                '2020-10-10 10:00',
                '2020-10-10 00:00',
                '2020-10-10 12:00',
                true
            ],
            [
                '2020-10-10 06:00',
                '2020-10-10 10:00',
                '2020-10-10 06:00',
                '2020-10-10 10:00',
                true
            ],
            [
                '2020-10-09 06:00',
                '2020-10-10 10:00',
                '2020-10-10 00:00',
                '2020-10-10 12:00',
                false
            ],
            [
                '2020-10-10 06:00',
                '2020-10-10 13:00',
                '2020-10-10 00:00',
                '2020-10-10 12:00',
                false
            ],
        ];
    }

    /** @dataProvider surroundDataProvider */
    public function testSurrounds(string $start, string $end, string $testStart, string $testEnd, bool $assertion)
    {
        $startDate = CarbonImmutable::parse($start);
        $endDate = CarbonImmutable::parse($end);

        $testStartDate = CarbonImmutable::parse($testStart);
        $testEndDate = CarbonImmutable::parse($testEnd);

        $timeSpan = new TimeSpan($startDate, $endDate);

        self::assertEquals($assertion, $timeSpan->surrounds($testStartDate, $testEndDate));
    }

    public function surroundDataProvider() : array {
        return [
            [
                '2020-10-10 00:00',
                '2020-10-10 10:00',
                '2020-10-10 09:00',
                '2020-10-10 09:59',
                true
            ],
            [
                '2020-10-09 06:00',
                '2020-10-10 10:00',
                '2020-10-10 00:00',
                '2020-10-10 12:00',
                false
            ],
            [
                '2020-10-10 06:00',
                '2020-10-10 13:00',
                '2020-10-10 00:00',
                '2020-10-10 12:00',
                false
            ],
        ];
    }

    /** @dataProvider partOfDataProvider */
    public function testPartOf(string $start, string $end, string $testStart, string $testEnd, bool $assertion)
    {
        $startDate = CarbonImmutable::parse($start);
        $endDate = CarbonImmutable::parse($end);

        $testStartDate = CarbonImmutable::parse($testStart);
        $testEndDate = CarbonImmutable::parse($testEnd);

        $timeSpan = new TimeSpan($startDate, $endDate);

        self::assertEquals($assertion, $timeSpan->partOf($testStartDate, $testEndDate));
    }

    public function partOfDataProvider() : array {
        return [
            [
                '2020-10-10 00:00',
                '2020-10-10 10:00',
                '2020-10-10 09:00',
                '2020-10-10 11:00',
                true
            ],
            [
                '2020-10-10 06:00',
                '2020-10-10 10:00',
                '2020-10-10 09:00',
                '2020-10-10 12:00',
                true
            ],
            [
                '2020-10-10 06:00',
                '2020-10-10 13:00',
                '2020-10-10 00:00',
                '2020-10-10 12:00',
                true
            ],
        ];
    }
}