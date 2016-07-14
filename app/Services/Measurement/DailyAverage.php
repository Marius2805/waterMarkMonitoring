<?php
namespace App\Services\Measurement;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Class DailyAverage
 * @package App\Services\Measurement
 */
class DailyAverage implements Jsonable, \JsonSerializable
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

    /**
     * @inheritdoc
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize());
    }

    /**
     * @inheritdoc
     */
    public function jsonSerialize()
    {
        return [
            'date'  => $this->date->format('Y-m-d'),
            'value' => round($this->value, 2)
        ];
    }
}