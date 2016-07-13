<?php
namespace Tests\App\Services\Measurement;

use App\Services\Measurement\Measurement;
use App\Services\Measurement\MeasurementRepository;
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

    protected function getRepositoryClassName() : string
    {
        return MeasurementRepository::class;
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
}