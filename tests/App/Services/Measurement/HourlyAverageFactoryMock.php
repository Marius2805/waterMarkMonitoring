<?php
namespace Tests\App\Services\Measurement;

use App\Services\Measurement\HourlyAverage;
use App\Services\Measurement\HourlyAverageFactory;
use Carbon\Carbon;

/**
 * Class HourlyAverageFactoryMock
 * @package Tests\App\Services\Measurement
 */
class HourlyAverageFactoryMock extends \PHPUnit_Framework_TestCase
{
    /**
     * @return HourlyAverageFactory
     */
    public function getFactory() : HourlyAverageFactory
    {
        $factory = $this->getMockBuilder(HourlyAverageFactory::class)->getMock();

        $factory->method('getAverages')
            ->will(self::returnCallback([$this, 'getAveragesCallback']));

        return $factory;
    }

    /**
     * @param int $limit
     * @return HourlyAverage[]
     */
    public function getAveragesCallback(int $limit) : array
    {
        $result = [];

        for ($i = 0; $i < $limit; $i++) {
            $result[] = new HourlyAverage(Carbon::now()->minute(0)->second(0)->subHours($i), 10);
        }

        return $result;
    }
}