<?php
namespace Tests\App\Services\Measurement;

use App\General\EntityRepository;
use App\Services\Measurement\Measurement;
use App\Services\Measurement\MeasurementRepository;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Tests\App\General\EntityRepositoryTestCase;

/**
 * Class MeasurementRepositoryIntegrationTest
 * @package App\Services\Measurement
 */
class MeasurementRepositoryIntegrationTest extends EntityRepositoryTestCase
{
    /**
     * @var MeasurementRepository
     */
    protected $repository;

    public function test_getDailyAverage_calculatedCorrectly()
    {
        $this->measure(Carbon::now(), 0);
        $this->measure(Carbon::now(), 5);

        $result = $this->repository->getDailyAverage(Carbon::now());
        self::assertEquals(2.5, $result);
    }

    /**
     * @expectedException \App\Services\Measurement\MeasurementNotFound
     * @expectedExceptionMessage No measurements found at day "2016-07-13".
     */
    public function test_getDailyAverage_noRecords()
    {
        $this->repository->getDailyAverage(Carbon::now());
    }

    /**
     * @return EntityRepository
     */
    protected function getRepository() : EntityRepository
    {
        return new MeasurementRepository();
    }

    /**
     * @return string
     */
    protected function getExpectedEntityClass() : string
    {
        return Measurement::class;
    }

    /**
     * @param bool $persist
     * @return Model
     */
    protected function createEntity(bool $persist = true) : Model
    {
        $measurement = new Measurement(['value' => 5.77]);

        if ($persist) {
            $measurement->save();
        }

        return $measurement;
    }

    private function measure(Carbon $time, float $value)
    {
        $measurement = new Measurement(['value' => $value]);
        $this->repository->save($measurement);
    }
}