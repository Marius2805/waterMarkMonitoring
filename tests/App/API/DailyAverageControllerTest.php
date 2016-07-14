<?php
namespace Tests\App\Http\Controllers\API;

use App\Http\Controllers\API\DailyAverageController;
use App\Services\Measurement\DailyAverage;
use Illuminate\Http\Request;
use Tests\App\Services\Measurement\DailyAverageFactoryMock;
use Tests\TestCase;

/**
 * Class DailyAverageControllerTest
 * @package App\Http\Controllers\API
 */
class DailyAverageControllerTest extends TestCase
{
    /**
     * @var DailyAverageController
     */
    private $controller;

    public function setUp()
    {
        parent::setUp();
        $mock = new DailyAverageFactoryMock();
        $this->controller = new DailyAverageController($mock->getFactory());
    }

    public function test_get_limitDefault()
    {
        $result = $this->controller->get(new Request());
        self::assertCount(DailyAverageController::DEFAULT_LIMIT, $result);
    }

    public function test_get_limit()
    {
        $result = $this->controller->get(new Request([], ['limit' => 3]));
        self::assertCount(3, $result);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Value "three" is not an integer.
     */
    public function test_get_limitNotInteger()
    {
        $this->controller->get(new Request([], ['limit' => 'three']));
    }

    public function test_get_correctResult()
    {
        $result = $this->controller->get(new Request([], ['limit' => 3]));

        /** @var DailyAverage $average */
        foreach ($result as $average) {
            self::assertInstanceOf(DailyAverage::class, $average);
            self::assertEquals(10, $average->getValue());
        }
    }
}