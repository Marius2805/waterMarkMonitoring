<?php
namespace App\Services\Measurement;

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