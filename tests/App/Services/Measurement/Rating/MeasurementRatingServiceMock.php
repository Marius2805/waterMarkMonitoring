<?php
namespace Tests\App\Services\Measurement\Rating;

use App\Services\Measurement\Measurement;
use App\Services\Measurement\Rating\MeasurementRatingService;

/**
 * Class MeasurementRatingServiceMock
 * @package Tests\App\Services\Measurement\Rating
 */
class MeasurementRatingServiceMock extends \PHPUnit_Framework_TestCase
{
    /**
     * @var bool
     */
    private $warningThresholdReachedResult = true;

    /**
     * @var bool
     */
    private $measurementGapDetectedResult = true;

    /**
     * @return MeasurementRatingService
     */
    public function getService() : MeasurementRatingService
    {
        $service = $this->getMockBuilder(MeasurementRatingService::class)->getMock();

        $service->method('warningThresholdReached')
            ->will(self::returnCallback([$this, 'warningThresholdReachedCallback']));
        $service->method('measurementGapDetected')
            ->will(self::returnCallback([$this, 'measurementGapDetectedCallback']));

        return $service;
    }

    /**
     * @param Measurement $measurement
     * @return bool
     */
    public function warningThresholdReachedCallback(Measurement $measurement) : bool
    {
        return $this->warningThresholdReachedResult;
    }

    /**
     * @return bool
     */
    public function measurementGapDetectedCallback() : bool
    {
        return $this->measurementGapDetectedResult;
    }

    /**
     * @param boolean $warningThresholdReachedResult
     */
    public function setWarningThresholdReachedResult (bool $warningThresholdReachedResult)
    {
        $this->warningThresholdReachedResult = $warningThresholdReachedResult;
    }

    /**
     * @param boolean $measurementGapDetectedResult
     */
    public function setMeasurementGapDetectedResult (bool $measurementGapDetectedResult)
    {
        $this->measurementGapDetectedResult = $measurementGapDetectedResult;
    }
}