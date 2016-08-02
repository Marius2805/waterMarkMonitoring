<?php
namespace App\Services\Measurement;

use Carbon\Carbon;

/**
 * Class AverageFactory
 * @package App\Services\Measurement
 */
abstract class AverageFactory
{
    /**
     * @var MeasurementRepository
     */
    protected $repository;

    /**
     * @var bool
     */
    private $cacheEnabled;

    /**
     * DailyAverageFactory constructor.
     * @param MeasurementRepository $repository
     * @param bool $enableCache
     */
    public function __construct(MeasurementRepository $repository = null, $enableCache = true)
    {
        $this->repository = $repository ?: new MeasurementRepository();
        $this->cacheEnabled = $enableCache;
    }

    /**
     * Returns the newest date for the statistic fetch iterator
     *
     * @return Carbon
     */
    abstract public function getStartDate() : Carbon;

    /**
     * Creates a fresh calculated average
     *
     * @param Carbon $date
     * @return Average
     */
    abstract protected function createAverage(Carbon $date) : Average;

    /**
     * Returns the unique date format for the specific average type
     *
     * @return string
     */
    abstract protected function getUniqueDateFormat() : string;

    /**
     * Returns the maximum limit to iterate/generate statistics
     *
     * @return int
     */
    abstract public function getMaxLimit() : int;

    /**
     * Returns the step size for generating/iterating statistics
     *
     * @return \DateInterval
     */
    abstract protected function getStepSize() : \DateInterval;

    /**
     * @param int $limit
     * @return DailyAverage[]
     */
    public function getAverages(int $limit)
    {
        $results  = [];
        $date     = $this->getStartDate();
        $maxLimit = $this->getMaxLimit();
        $stepSize = $this->getStepSize();

        for ($i = 0; count($results) < $limit && $i < $maxLimit; $i++) {
            $dailyAverage = $this->getAverageForDate($date);
            if ($dailyAverage != null) {
                $results[] = $dailyAverage;
            }
            $date->sub($stepSize);
        }

        return $results;
    }

    /**
     * @param Carbon $date
     * @return DailyAverage
     */
    private function getAverageForDate(Carbon $date)
    {
        $dailyAverage = $this->getFromCache($date);

        if ($dailyAverage == null) {
            try {
                $dailyAverage = $this->createAverage($date);
                $this->addToCache($dailyAverage);
            } catch (MeasurementNotFound $e) {}
        }

        return $dailyAverage;
    }

    /**
     * @param Average $average
     */
    private function addToCache(Average $average)
    {
        if ($this->cacheEnabled && $average->getDate()->format($this->getUniqueDateFormat()) != Carbon::now()->format($this->getUniqueDateFormat())) {
            $limit = Carbon::today()->subDays(8)->diffInMinutes(Carbon::today());
            $key   = $this->getCacheKey($average->getDate());
            \Cache::add($key, $average, $limit);
        }
    }

    /**
     * @param Carbon $date
     * @return DailyAverage
     */
    private function getFromCache(Carbon $date)
    {
        return $this->cacheEnabled ? \Cache::get($this->getCacheKey($date)) : null;
    }

    /**
     * @param Carbon $date
     * @return string
     */
    private function getCacheKey(Carbon $date) : string
    {
        return $date->format($this->getUniqueDateFormat());
    }
}