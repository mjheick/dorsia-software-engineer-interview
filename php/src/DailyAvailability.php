<?php

namespace Interview;

/**
 * This class is responsible for outputting a range of available seating options
 * depending on restaurant settings.
 */
class DailyAvailability {
    public ?int $excludedStartTime = null;
    public ?int $excludedEndTime = null;
    public ?int $StartTime = null;
    public ?int $EndTime = null;

    /**
     * New instances of this class accept the start and end minutes to create a time range.
     *
     * @param int $startTime The minute of the day from which the time range begins (e.g. midnight + start minutes)
     * @param int $endTime The minute of the day of which the time range ends (e.g. midnight + end minutes)
     */
    public function __construct(public int $startTime, public int $endTime)
    {
        $this->StartTime = $startTime;
        $this->EndTime = $endTime;
    }


    /**
     * Defines an excluded time period for this instance of DailyAvailability.
     */
    public function exclude(int $startTime, int $endTime): void
    {
        if ($startTime > $endTime)
        {
            $this->excludedStartTime = $endTime;
            $this->excludedEndTime = $startTime;
        }
        else
        {
            $this->excludedStartTime = $startTime;
            $this->excludedEndTime = $endTime;
        }
    }

    /**
     * Returns all seating options available between the start and end times on a given interval, excluding any
     * defined exclusion times.
     *
     * For instance, if the interval given is 15 minutes, the method will all options between the start
     * and end times (0, 15, 30, 45, 60).
     *
     * @param int $intervalInMinutes
     * @return int[]
     */
    public function getOptions(int $intervalInMinutes): array
    {
        $intervals = [];
        $interval_start = $this->StartTime;
        while ($interval_start <= $this->EndTime)
        {
            if (!is_null($this->excludedStartTime)) {
                if (!(($interval_start >= $this->excludedStartTime) && ($interval_start <= $this->excludedEndTime)))
                {
                    $intervals[] = $interval_start;
                }
            }
            else
            {
                $intervals[] = $interval_start;
            }
            $interval_start += $intervalInMinutes;
        }
        return $intervals;
    }
}