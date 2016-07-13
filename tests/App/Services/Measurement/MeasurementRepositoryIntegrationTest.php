<?php
namespace Tests\App\Services\Measurement;

use App\General\EntityRepository;
use App\Services\Measurement\Measurement;
use App\Services\Measurement\MeasurementRepository;
use Illuminate\Database\Eloquent\Model;
use Tests\App\General\EntityRepositoryTestCase;

/**
 * Class MeasurementRepositoryIntegrationTest
 * @package App\Services\Measurement
 */
class MeasurementRepositoryIntegrationTest extends EntityRepositoryTestCase
{
    /**
     * @return EntityRepository
     */
    protected function getRepository() : EntityRepository
    {
        return new MeasurementRepository();
    }

    /**
     * @return string
     */
    protected function getExpectedEntityClass() : string
    {
        return Measurement::class;
    }

    /**
     * @param bool $persist
     * @return Model
     */
    protected function createEntity(bool $persist = true) : Model
    {
        $measurement = new Measurement(['value' => 5.77]);

        if ($persist) {
            $measurement->save();
        }

        return $measurement;
    }
}