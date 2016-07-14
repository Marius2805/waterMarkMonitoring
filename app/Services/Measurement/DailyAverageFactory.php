<?php
namespace App\Services\Measurement;

use Carbon\Carbon;

/**
 * Class DailyAverageFactory
 * @package App\Services\Measurement
 */
class DailyAverageFactory
{
    const MAX_LIMIT = 20;

    /**
     * @var MeasurementRepository
     */
    private $repository;

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
     * @param int $limit
     * @return DailyAverage[]
     */
    public function getAverages(int $limit)
    {
        $results = [];
        $date = Carbon::today();

        for ($i = 0; count($results) < $limit && $i < self::MAX_LIMIT; $i++) {
            $dailyAverage = $this->getDailyAverage($date);
            if ($dailyAverage != null) {
                $results[] = $dailyAverage;
            }
            $date->subDays(1);
        }

        return $results;
    }

    /**
     * @param Carbon $date
     * @return DailyAverage
     */
    private function getDailyAverage(Carbon $date)
    {
        $dailyAverage = $this->getFromCache($date);

        if ($dailyAverage == null) {
            try {
                $dailyAverage = new DailyAverage(clone $date, $this->repository->getDailyAverage($date));
                $this->addToCache($dailyAverage);
            } catch (MeasurementNotFound $e) {}
        }

        return $dailyAverage;
    }

    /**
     * @param DailyAverage $dailyAverage
     */
    private function addToCache(DailyAverage $dailyAverage)
    {
        if ($this->cacheEnabled && $dailyAverage->getDate() != Carbon::today()) {
            $limit = Carbon::today()->endOfDay()->diffInMinutes(Carbon::now());
            $key   = $this->getCacheKey($dailyAverage->getDate());
            \Cache::add($key, $dailyAverage, $limit);
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
        return $date->format('Y-m-d');
    }
}