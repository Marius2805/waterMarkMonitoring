<?php
namespace App\Services\Measurement;

use App\General\EntityRepository;
use App\Services\Measurement\Statistics\MeasurementNotFound;
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
     * @return Measurement
     */
    public function getLastMeasurement()
    {
        return Measurement::orderBy('created_at', 'desc')->first();
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

    /**
     * @param Carbon $hour
     * @return float
     * @throws MeasurementNotFound
     */
    public function getHourlyAverage(Carbon $hour) : float
    {
        $start = (clone $hour)->minute(0)->second(0);
        $end   = (clone $hour)->minute(59)->second(59);

        $result = $this->getConnection()->table($this->getTable())->whereBetween('created_at', [$start, $end])->avg('value');

        if (is_null($result)) {
            throw new MeasurementNotFound('No measurements found at hour "' . $start->toTimeString() . '".');
        }

        return $result;
    }
}