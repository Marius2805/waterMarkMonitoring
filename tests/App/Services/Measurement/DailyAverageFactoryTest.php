<?php
namespace Tests\App\Services\Measurement;

use App\Services\Measurement\DailyAverage;
use App\Services\Measurement\DailyAverageFactory;
use Carbon\Carbon;
use Tests\App\General\IntegrationTest;

/**
 * Class DailyAverageFactoryIntegrationTest
 * @package Tests\App\Services\Measurement
 */
class DailyAverageFactoryTest extends IntegrationTest
{
    /**
     * @var DailyAverageFactory
     */
    private $factory;

    public function setUp()
    {
        parent::setUp();

        $repositoryMock = new MeasurementRepositoryMock();
        $this->factory = new DailyAverageFactory($repositoryMock->getRepository(), false);
    }

    public function test_getAverages_allAveragesFound()
    {
        $results = $this->factory->getAverages(2);

        self::assertCount(2, $results);
        foreach ($results as $i => $result) {
            self::assertInstanceOf(DailyAverage::class, $result);
            self::assertEquals(10, $result->getValue());
            self::assertEquals(Carbon::today()->subDays($i), $result->getDate());
        }
    }

    public function test_getAverages_gapsIgnored()
    {
        $results = $this->factory->getAverages(3);

        self::assertCount(3, $results);
        self::assertEquals(Carbon::today()->subDays(3), last($results)->getDate());
        self::assertEquals(20, last($results)->getValue());
    }

    public function test_getAverages_maxLimitReachedBecauseOfGaps()
    {
        $results = $this->factory->getAverages(DailyAverageFactory::MAX_LIMIT - 1);
        self::assertLessThan(DailyAverageFactory::MAX_LIMIT, count($results));
    }

    public function test_getAverages_limitExceedsMaxLimit()
    {
        $results = $this->factory->getAverages(1000000);
        self::assertLessThan(DailyAverageFactory::MAX_LIMIT + 1, count($results));
    }
}