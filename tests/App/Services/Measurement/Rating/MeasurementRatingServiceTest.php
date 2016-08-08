<?php
namespace Tests\App\Services\Measurement\Rating;

use App\Services\Measurement\Measurement;
use App\Services\Measurement\MeasurementRepository;
use App\Services\Measurement\Rating\MeasurementRatingService;
use Carbon\Carbon;
use Tests\App\Services\Configuration\SettingsRepositoryMock;
use Tests\App\Services\Measurement\MeasurementRepositoryMock;
use Tests\TestCase;

/**
 * Class MeasurementRatingServiceTest
 * @package Tests\App\Services\Measurement\Rating
 */
class MeasurementRatingServiceTest extends TestCase
{
    /**
     * @var MeasurementRatingService
     */
    private $service;

    /**
     * @var MeasurementRepository
     */
    private $measurementRepository;

    public function __construct()
    {
        parent::__construct();
        $settingsRepositoryMock = new SettingsRepositoryMock();
        $measurementRepositoryMock = new MeasurementRepositoryMock();
        $this->measurementRepository = $measurementRepositoryMock->getRepository();

        $this->service = new MeasurementRatingService($settingsRepositoryMock->getRepository(), $this->measurementRepository);
    }

    public function test_warningThresholdReached_aboveLimit_false()
    {
        $measurement = new Measurement(['value' => 15]);
        $result = $this->service->warningThresholdReached($measurement);

        self::assertFalse($result);
    }

    public function test_warningThresholdReached_equalValues_true()
    {
        $measurement = new Measurement(['value' => 10]);
        $result = $this->service->warningThresholdReached($measurement);

        self::assertTrue($result);
    }

    public function test_warningThresholdReached_underLimit_true()
    {
        $measurement = new Measurement(['value' => 9]);
        $result = $this->service->warningThresholdReached($measurement);

        self::assertTrue($result);
    }

    public function test_measurementGapDetected_underLimit_false()
    {
        $measurement = new Measurement();
        $measurement->created_at = Carbon::now();
        $this->measurementRepository->save($measurement);
        $result = $this->service->measurementGapDetected();

        self::assertFalse($result);
    }

    public function test_measurementGapDetected_aboveLimit_true()
    {
        $measurement = new Measurement();
        $measurement->created_at = Carbon::now()->subMinutes(181);
        $this->measurementRepository->save($measurement);
        $result = $this->service->measurementGapDetected();

        self::assertTrue($result);
    }
}