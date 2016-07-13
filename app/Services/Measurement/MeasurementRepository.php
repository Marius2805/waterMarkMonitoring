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
     * @return string
     */
    protected function getEntityClass() : string
    {
        return Measurement::class;
    }

    public function getDailyAverage(Carbon $day) : float
    {
        $result = $this->getConnection()->connection()->table($this->getTable())->whereBetween('created_at', [clone $day->startOfDay(), clone $day->endOfDay()])->avg('value');

        if (is_null($result)) {
            throw new MeasurementNotFound('No measurements found at day "' . $day->startOfDay()->toDateString() . '".');
        }

        return $result;
    }
}