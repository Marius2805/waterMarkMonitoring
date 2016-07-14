<?php
namespace Tests\App\General;

use App\Services\Measurement\Measurement;
use App\Services\Measurement\MeasurementRepository;
use Carbon\Carbon;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Class IntegrationTest
 * @package Tests\App\General
 */
abstract class IntegrationTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp()
    {
        parent::setUp();
        \Cache::flush();
    }

    public function tearDown()
    {
        \Cache::flush();
        parent::tearDown();
    }

    /**
     * Creates a new saved Measurement
     *
     * @param Carbon $time
     * @param float $value
     * @return Measurement
     */
    protected function measure(Carbon $time, float $value) : Measurement
    {
        $measurement = new Measurement(['value' => $value]);
        $measurement->created_at = $time;

        $repository = new MeasurementRepository();
        $repository->save($measurement);

        return $measurement;
    }
}