<?php
namespace Tests\App\Http\Controllers\API;

use App\Http\Controllers\API\AverageController;
use App\Http\Controllers\API\DailyAverageController;
use App\Services\Measurement\DailyAverage;
use Tests\App\Services\Measurement\DailyAverageFactoryMock;

/**
 * Class DailyAverageControllerTest
 * @package App\Http\Controllers\API
 */
class DailyAverageControllerTest extends AverageControllerTest
{
    /**
     * @return AverageController
     */
    protected function getController() : AverageController
    {
        $mock = new DailyAverageFactoryMock();
        return new DailyAverageController($mock->getFactory());
    }

    /**
     * @return string
     */
    protected function getExpectedAverageClass() : string
    {
        return DailyAverage::class;
    }
}