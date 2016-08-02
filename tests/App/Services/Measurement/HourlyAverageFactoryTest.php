<?php
namespace Tests\App\Services\Measurement;

use App\Services\Measurement\AverageFactory;
use App\Services\Measurement\HourlyAverage;
use App\Services\Measurement\HourlyAverageFactory;

/**
 * Class HourlyAverageFactoryTest
 * @package Tests\App\Services\Measurement
 */
class HourlyAverageFactoryTest extends AverageFactoryTest
{
    /**
     * @inheritdoc
     */
    protected function createFactory() : AverageFactory
    {
        $repositoryMock = new MeasurementRepositoryMock();
        return new HourlyAverageFactory($repositoryMock->getRepository(), false);
    }

    /**
     * @inheritdoc
     */
    protected function getExpectedAverageStep() : int
    {
        return 60;
    }

    /**
     * @inheritdoc
     */
    protected function getExpectedAverageClass() : string
    {
        return HourlyAverage::class;
    }
}