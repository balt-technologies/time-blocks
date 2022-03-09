<?php

declare(strict_types=1);

namespace TimeBlocks;

use Carbon\CarbonImmutable;
use DateTimeImmutable;

final class TimeSpan
{
    private CarbonImmutable $startDate;
    private CarbonImmutable $endDate;

    public function __construct(DateTimeImmutable $startDate, DateTimeImmutable $endDate)
    {
        $this->startDate = CarbonImmutable::parse($startDate);
        $this->endDate = CarbonImmutable::parse($endDate);
    }

    public function between(DateTimeImmutable $startDate, DateTimeImmutable $endDate, ?bool $equal = true): bool
    {
        $startDate = CarbonImmutable::parse($startDate)->toImmutable();
        $endDate = CarbonImmutable::parse($endDate)->toImmutable();

        return $this->startDate->isBetween($startDate, $endDate, $equal) &&
            $this->endDate->isBetween($startDate, $endDate, $equal);
    }

    public function surrounds(DateTimeImmutable $startDate, DateTimeImmutable $endDate): bool
    {
        $startDate = CarbonImmutable::parse($startDate)->toImmutable();
        $endDate = CarbonImmutable::parse($endDate)->toImmutable();

        return $this->startDate->isBefore($startDate) && $this->endDate->isAfter($endDate);
    }

    public function partOf(DateTimeImmutable $startDate, DateTimeImmutable $endDate): bool
    {
        $startDate = CarbonImmutable::parse($startDate)->toImmutable();
        $endDate = CarbonImmutable::parse($endDate)->toImmutable();

        return $this->startDate->between($startDate, $endDate, false) ||
            $this->endDate->between($startDate, $endDate, false);
    }

    public function in(DateTimeImmutable $date): bool
    {
        $date = CarbonImmutable::parse($date)->toImmutable();

        return $date->isBetween($this->startDate, $this->endDate, false);
    }

    public function before(DateTimeImmutable $date): bool
    {
        return $this->endDate->isBefore($date) || $this->endDate->equalTo($date);
    }

    public function after(DateTimeImmutable $date): bool
    {
        return $this->startDate->isAfter($date) || $this->startDate->equalTo($date);
    }

    public function getStartDate(): DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(DateTimeImmutable $startDate): void
    {
        $this->startDate = CarbonImmutable::parse($startDate);
    }

    public function getEndDate(): DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(DateTimeImmutable $endDate): void
    {
        $this->endDate = CarbonImmutable::parse($endDate);
    }
}
