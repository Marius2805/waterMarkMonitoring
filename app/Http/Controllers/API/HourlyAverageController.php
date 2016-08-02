<?php
namespace App\Http\Controllers\API;

use App\Services\Measurement\HourlyAverageFactory;

/**
 * Class HourlyAverageController
 * @package App\Http\Controllers\API
 */
class HourlyAverageController extends AverageController
{
    /**
     * HourlyAverageController constructor.
     * @param HourlyAverageFactory $averageFactory
     */
    public function __construct(HourlyAverageFactory $averageFactory)
    {
        $averageFactory = $averageFactory ?: new HourlyAverageFactory();
        parent::__construct($averageFactory);
    }

    /**
     * @return int
     */
    public function getDefaultLimit() : int
    {
        return 24;
    }
}