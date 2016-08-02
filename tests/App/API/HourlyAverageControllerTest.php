<?php
namespace Tests\App\Http\Controllers\API;

use App\Http\Controllers\API\AverageController;
use App\Http\Controllers\API\HourlyAverageController;
use App\Services\Measurement\HourlyAverage;
use Tests\App\Services\Measurement\HourlyAverageFactoryMock;

/**
 * Class HourlyAverageControllerTest
 * @package Tests\App\Http\Controllers\API
 */
class HourlyAverageControllerTest extends AverageControllerTest
{
    /**
     * @return AverageController
     */
    protected function getController() : AverageController
    {
        $mock = new HourlyAverageFactoryMock();
        return new HourlyAverageController($mock->getFactory());
    }

    /**
     * @return string
     */
    protected function getExpectedAverageClass() : string
    {
        return HourlyAverage::class;
    }
}