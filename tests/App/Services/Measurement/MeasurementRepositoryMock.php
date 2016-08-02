<?php
namespace Tests\App\Services\Measurement;

use App\General\EntityRepository;
use App\Services\Measurement\Measurement;
use App\Services\Measurement\MeasurementNotFound;
use App\Services\Measurement\MeasurementRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Tests\App\General\EntityRepositoryMock;

/**
 * Class MeasurementRepositoryMock
 * @package Tests\App\Services\Measurement
 */
class MeasurementRepositoryMock extends EntityRepositoryMock
{
    /**
     * @var Measurement
     */
    private $savedEntity;

    /**
     * @return EntityRepository
     */
    public function getRepository() : EntityRepository
    {
        /** @var \PHPUnit_Framework_MockObject_MockObject $repository */
        $repository = parent::getRepository();

        $repository->method('getDailyAverage')
            ->will(self::returnCallback([$this, 'getDailyAverageCallback']));

        $repository->method('getHourlyAverage')
            ->will(self::returnCallback([$this, 'getHourlyAverageCallback']));

        return $repository;
    }

    /**
     * @param Carbon $time
     * @return float
     * @throws MeasurementNotFound
     */
    public function getHourlyAverageCallback(Carbon $time) : float
    {
        switch ($time->diffInHours(Carbon::now())) {
            case 0:
                return 10;
                break;
            case 1:
                return 10;
                break;
            case 3:
                return 20;
                break;
            default:
                throw new MeasurementNotFound('Average not found in mock!');
        }
    }

    /**
     * @param Carbon $time
     * @return float
     * @throws MeasurementNotFound
     */
    public function getDailyAverageCallback(Carbon $time) : float
    {
        switch ($time->diffInDays(Carbon::now())) {
            case 0:
                return 10;
                break;
            case 1:
                return 10;
                break;
            case 3:
                return 20;
                break;
            default:
                throw new MeasurementNotFound('Average not found in mock!');
        }
    }

    public function saveEntity(Model $entity)
    {
        parent::saveEntity($entity);
        $this->savedEntity = $entity;
    }

    public function getByIdCallback(int $id)
    {
        return $this->savedEntity ?: new Measurement();
    }

    protected function getRepositoryClassName() : string
    {
        return MeasurementRepository::class;
    }
}