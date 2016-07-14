<?php
namespace App\Services\Measurement;

use Carbon\Carbon;

/**
 * Class DailyAverage
 * @package App\Services\Measurement
 */
class DailyAverage
{
    /**
     * @var Carbon
     */
    private $date;

    /**
     * @var float
     */
    private $value;

    /**
     * DailyAverage constructor.
     * @param Carbon $date
     * @param float $value
     */
    public function __construct(Carbon $date, float $value)
    {
        $this->date = $date;
        $this->value = $value;
    }

    /**
     * @return Carbon
     */
    public function getDate() : Carbon
    {
        return $this->date;
    }

    /**
     * @return float
     */
    public function getValue() : float
    {
        return $this->value;
    }
}