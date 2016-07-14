<?php
namespace App\Services\Measurement;

use App\General\EntityRepository;
use Carbon\Carbon;

/**
 * Class MeasurementRepository
 * @method Measurement getById(int $id) : Model
 * @package App\Services\Measurement
 */
class MeasurementRepository extends EntityRepository
{
    /**
     * @var bool
     */
    protected $cacheEnabled = false;

    /**
     * @return string
     */
    protected function getEntityClass() : string
    {
        return Measurement::class;
    }

    /**
     * @param Carbon $day
     * @return float
     * @throws MeasurementNotFound
     */
    public function getDailyAverage(Carbon $day) : float
    {
        $result = $this->getConnection()->table($this->getTable())->whereBetween('created_at', [clone $day->startOfDay(), clone $day->endOfDay()])->avg('value');

        if (is_null($result)) {
            throw new MeasurementNotFound('No measurements found at day "' . $day->startOfDay()->toDateString() . '".');
        }

        return $result;
    }
}