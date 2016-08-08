<?php
namespace App\Services\Measurement\Rating;

use App\Services\Configuration\SettingsRepository;
use App\Services\Measurement\Measurement;
use App\Services\Measurement\MeasurementRepository;
use Carbon\Carbon;

/**
 * Class MeasurementRatingService
 * @package App\Services\Measurement\Rating
 */
class MeasurementRatingService
{
    /**
     * @var SettingsRepository
     */
    private $settingsRepository;

    /**
     * @var MeasurementRepository
     */
    private $measurementsRepository;

    /**
     * MeasurementRatingService constructor.
     * @param SettingsRepository|null $settingsRepository
     * @param MeasurementRepository $measurementRepository
     */
    public function __construct(SettingsRepository $settingsRepository = null, MeasurementRepository $measurementRepository = null)
    {
        $this->settingsRepository = $settingsRepository ?: new SettingsRepository();
        $this->measurementsRepository = $measurementRepository ?: new MeasurementRepository();
    }

    /**
     * Watermark reached warning threshold limit?
     *
     * @param Measurement $measurement
     * @return bool
     */
    public function warningThresholdReached(Measurement $measurement) : bool
    {
        $setting = $this->settingsRepository->get(SettingsRepository::WATER_MARK_WARNING_THRESHOLD);
        return $measurement->value <= $setting->value;
    }

    /**
     * Last measurement older then gap limit
     *
     * @return bool
     */
    public function measurementGapDetected() : bool
    {
        $setting = $this->settingsRepository->get(SettingsRepository::MEASUREMENT_GAP_WARNING_THRESHOLD);
        $lastMeasurement = $this->measurementsRepository->getLastMeasurement();

        return Carbon::now()->diffInMinutes($lastMeasurement->created_at) >= $setting->value;
    }
}