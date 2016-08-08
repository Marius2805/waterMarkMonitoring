<?php
namespace App\Http\Controllers;

use App\Services\Configuration\SettingsRepository;
use App\Services\Measurement\Measurement;
use App\Services\Measurement\MeasurementRepository;
use App\Services\Measurement\Rating\MeasurementRatingService;
use Carbon\Carbon;
use Illuminate\View\View;

/**
 * Class OverviewController
 * @package App\Http\Controllers
 */
class OverviewController extends Controller
{
    /**
     * @var MeasurementRepository
     */
    private $measurementRepository;

    /**
     * @var SettingsRepository
     */
    private $settingsRepository;

    /**
     * @var MeasurementRatingService
     */
    private $ratingService;

    /**
     * OverviewController constructor.
     * @param MeasurementRepository|null $measurementRepository
     * @param SettingsRepository $settingsRepository
     * @param MeasurementRatingService $measurementRatingService
     */
    public function __construct(MeasurementRepository $measurementRepository = null, SettingsRepository $settingsRepository = null, MeasurementRatingService $measurementRatingService)
    {
        $this->measurementRepository = $measurementRepository ?: new MeasurementRepository();
        $this->settingsRepository = $settingsRepository ?: new SettingsRepository();
        $this->ratingService = $measurementRatingService ?: new MeasurementRatingService();
    }

    /**
     * @return View
     */
    public function overview() : View
    {
        $lastMeasurement = $this->measurementRepository->getLastMeasurement();
        $data = [
            'lastMeasurementValue'  => round($lastMeasurement->value, 2),
            'lastMeasurementOffset' => Carbon::now()->diffInMinutes($lastMeasurement->created_at),
            'waterMarkWarning'      => $this->ratingService->warningThresholdReached($lastMeasurement),
            'gapWarning'            => $this->ratingService->measurementGapDetected(),
            'gapWarningLimit'       => ($this->settingsRepository->get(SettingsRepository::MEASUREMENT_GAP_WARNING_THRESHOLD))->value
        ];

        return view('overview', $data);
    }
}