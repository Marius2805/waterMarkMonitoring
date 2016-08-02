<?php
namespace App\Services\Measurement\Statistics;

/**
 * Class DailyAverage
 * @package App\Services\Measurement
 */
class DailyAverage extends Average
{
    /**
     * @inheritdoc
     */
    protected function getDateFormat() : string
    {
        return 'Y-m-d';
    }
}