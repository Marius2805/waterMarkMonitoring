<?php
namespace App\Services\Measurement;
use App\General\EntityRepository;

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
}