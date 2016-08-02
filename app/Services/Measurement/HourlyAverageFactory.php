<?php
namespace App\Services\Measurement;

use Carbon\Carbon;

/**
 * Class HourlyAverageFactory
 * @package App\Services\Measurement
 */
class HourlyAverageFactory extends AverageFactory
{
    const MAX_LIMIT = 24;

    /**
     * @inheritdoc
     */
    protected function createAverage(Carbon $date) : Average
    {
        return new HourlyAverage(clone $date, $this->repository->getHourlyAverage($date));
    }

    /**
     * @inheritdoc
     */
    protected function getUniqueDateFormat() : string
    {
        return 'Y-m-d-H';
    }

    /**
     * @inheritdoc
     */
    public function getMaxLimit() : int
    {
        return self::MAX_LIMIT;
    }

    /**
     * @inheritdoc
     */
    protected function getStepSize() : \DateInterval
    {
        return new \DateInterval('PT1H');
    }

    /**
     * @inheritdoc
     */
    public function getStartDate() : Carbon
    {
        return Carbon::now()->minute(0)->second(0);
    }
}