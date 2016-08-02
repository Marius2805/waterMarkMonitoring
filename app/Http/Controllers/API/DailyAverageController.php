<?php
namespace App\Http\Controllers\API;

use App\Services\Measurement\Statistics\DailyAverageFactory;

/**
 * Class DailyAverageController
 * @package App\Http\Controllers\API
 */
class DailyAverageController extends AverageController
{
    /**
     * DailyAverageController constructor.
     *
     * @param DailyAverageFactory $factory
     */
    public function __construct(DailyAverageFactory $factory = null)
    {
        $factory = $factory ?: new DailyAverageFactory();
        parent::__construct($factory);
    }

    /**
     * @return int
     */
    public function getDefaultLimit() : int
    {
        return 7;
    }
}