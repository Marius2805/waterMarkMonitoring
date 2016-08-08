<?php
namespace Tests\App\Services\Measurement\Statistics;

use App\Services\Measurement\Statistics\DailyAverage;
use App\Services\Measurement\Statistics\DailyAverageFactory;
use Carbon\Carbon;

/**
 * Class DailyAverageFactoryMock
 * @package Tests\App\Services\Measurement
 */
class DailyAverageFactoryMock extends \PHPUnit_Framework_TestCase
{
    /**
     * @return DailyAverageFactory
     */
    public function getFactory() : DailyAverageFactory
    {
        $factory = $this->getMockBuilder(DailyAverageFactory::class)->getMock();

        $factory->method('getAverages')
            ->will(self::returnCallback([$this, 'getAveragesCallback']));

        return $factory;
    }

    /**
     * @param int $limit
     * @return DailyAverage[]
     */
    public function getAveragesCallback(int $limit) : array
    {
        $result = [];

        for ($i = 0; $i < $limit; $i++) {
            $result[] = new DailyAverage(Carbon::today()->subDays($i), 10);
        }

        return $result;
    }
}