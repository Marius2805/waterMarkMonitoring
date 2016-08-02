<?php
namespace App\Services\Measurement\Statistics;

/**
 * Class HourlyAverage
 * @package App\Services\Measurement
 */
class HourlyAverage extends Average
{
    /**
     * @inheritdoc
     */
    protected function getDateFormat() : string
    {
        return 'Y-m-d H';
    }
}