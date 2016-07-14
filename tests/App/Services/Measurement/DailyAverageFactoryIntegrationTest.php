<?php
namespace Tests\App\Services\Measurement;

use App\Services\Measurement\DailyAverageFactory;
use Carbon\Carbon;
use Tests\App\General\IntegrationTest;

/**
 * Class DailyAverageFactoryIntegrationTest
 * @package Tests\App\Services\Measurement
 */
class DailyAverageFactoryIntegrationTest extends IntegrationTest
{
    /**
     * @var DailyAverageFactory
     */
    private $factory;

    public function setUp()
    {
        parent::setUp();

        $this->factory = new DailyAverageFactory();
    }

    public function test_getAverages_CacheUsed()
    {
        $this->measure(Carbon::yesterday(), 10);
        $before = $this->factory->getAverages(1);

        self::assertCount(1, $before);
        self::assertEquals(10, $before[0]->getValue());

        $this->measure(Carbon::yesterday(), 20);
        $after = $this->factory->getAverages(1);

        self::assertEquals($before, $after);
    }

    public function test_getAverages_CacheNotUsedForToday()
    {
        $this->measure(Carbon::today(), 10);
        $before = $this->factory->getAverages(1);

        self::assertCount(1, $before);
        self::assertEquals(10, $before[0]->getValue());

        $this->measure(Carbon::today(), 20);
        $after = $this->factory->getAverages(1);

        self::assertNotEquals($before, $after);
    }
}