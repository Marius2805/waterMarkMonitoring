<?php
namespace App\Services\Measurement\Statistics;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Class Average
 * @package App\Services\Measurement
 */
abstract class Average implements Jsonable, \JsonSerializable
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
     * Date format for JSON serialisation
     *
     * @return string
     */
    abstract protected function getDateFormat() : string;

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
            'date'  => $this->date->timezone('Europe/Berlin')->format($this->getDateFormat()),
            'value' => round($this->value, 2)
        ];
    }
}