<?php
namespace Tests\App\Services\Measurement\Statistics;

use App\Services\Measurement\Statistics\AverageFactory;
use App\Services\Measurement\Statistics\DailyAverage;
use App\Services\Measurement\Statistics\DailyAverageFactory;
use Tests\App\Services\Measurement\MeasurementRepositoryMock;
use Tests\App\Services\Measurement\Statistics\AverageFactoryTest;

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