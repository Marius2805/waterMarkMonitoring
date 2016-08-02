<?php
namespace App\Services\Measurement\Statistics;

use Carbon\Carbon;

/**
 * Class DailyAverageFactory
 * @package App\Services\Measurement
 */
class DailyAverageFactory extends AverageFactory
{
    const MAX_LIMIT = 20;

    /**
     * @inheritdoc
     */
    protected function createAverage(Carbon $date) : Average
    {
        return new DailyAverage(clone $date, $this->repository->getDailyAverage($date));
    }

    /**
     * @inheritdoc
     */
    protected function getUniqueDateFormat() : string
    {
        return 'Y-m-d';
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
        return new \DateInterval('P1D');
    }

    /**
     * @inheritdoc
     */
    public function getStartDate() : Carbon
    {
        return Carbon::today();
    }
}