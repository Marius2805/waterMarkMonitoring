<?php
namespace Tests\App\Services\Measurement;

use App\Services\Measurement\AverageFactory;
use App\Services\Measurement\DailyAverage;
use App\Services\Measurement\DailyAverageFactory;

/**
 * Class DailyAverageFactoryIntegrationTest
 * @package Tests\App\Services\Measurement
 */
class DailyAverageFactoryTest extends AverageFactoryTest
{
    protected function createFactory() : AverageFactory
    {
        $repositoryMock = new MeasurementRepositoryMock();
        return new DailyAverageFactory($repositoryMock->getRepository(), false);
    }

    protected function getExpectedAverageStep() : int
    {
        return 1440;
    }

    protected function getExpectedAverageClass() : string
    {
        return DailyAverage::class;
    }
}