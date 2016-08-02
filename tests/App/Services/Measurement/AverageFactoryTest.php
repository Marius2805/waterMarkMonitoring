<?php
namespace Tests\App\Services\Measurement;

use App\Services\Measurement\AverageFactory;
use Tests\App\General\IntegrationTest;

/**
 * Class AverageFactoryTest
 * @package Tests\App\Services\Measurement
 */
abstract class AverageFactoryTest extends IntegrationTest
{
    /**
     * @var AverageFactory
     */
    private $factory;

    public function setUp()
    {
        parent::setUp();
        $this->factory = $this->createFactory();
    }

    /**
     * @return AverageFactory
     */
    abstract protected function createFactory() : AverageFactory;

    /**
     * Returns the expected statistics step in minutes
     *
     * @return int
     */
    abstract protected function getExpectedAverageStep() : int;

    /**
     * @return string
     */
    abstract protected function getExpectedAverageClass() : string;

    public function test_getAverages_allAveragesFound()
    {
        $results = $this->factory->getAverages(2);

        self::assertCount(2, $results);
        foreach ($results as $i => $result) {
            self::assertInstanceOf($this->getExpectedAverageClass(), $result);
            self::assertEquals(10, $result->getValue());
            $expectedStep = $this->getExpectedAverageStep() * $i;
            self::assertEquals($this->factory->getStartDate()->subMinutes($expectedStep), $result->getDate());
        }
    }

    public function test_getAverages_gapsIgnored()
    {
        $results = $this->factory->getAverages(3);

        self::assertCount(3, $results);
        $expectedMinuteOffset = $this->getExpectedAverageStep() * 3;
        self::assertEquals($this->factory->getStartDate()->subMinutes($expectedMinuteOffset), last($results)->getDate());
        self::assertEquals(20, last($results)->getValue());
    }

    public function test_getAverages_maxLimitReachedBecauseOfGaps()
    {
        $results = $this->factory->getAverages($this->factory->getMaxLimit() - 1);
        self::assertLessThan($this->factory->getMaxLimit(), count($results));
    }

    public function test_getAverages_limitExceedsMaxLimit()
    {
        $results = $this->factory->getAverages(1000000);
        self::assertLessThan($this->factory->getMaxLimit(), count($results));
    }
}