<?php
namespace Tests\App\Http\Controllers\API;

use App\Http\Controllers\API\AverageController;
use App\Services\Measurement\Average;
use Illuminate\Http\Request;
use Tests\TestCase;

/**
 * Class AverageControllerTest
 * @package Tests\App\Http\Controllers\API
 */
abstract class AverageControllerTest extends TestCase
{
    /**
     * @var AverageController
     */
    private $controller;

    public function setUp()
    {
        parent::setUp();
        $this->controller = $this->getController();
    }

    /**
     * @return AverageController
     */
    abstract protected function getController() : AverageController;

    /**
     * @return string
     */
    abstract protected function getExpectedAverageClass() : string;

    public function test_get_limitDefault()
    {
        $result = $this->controller->get(new Request());
        self::assertCount($this->controller->getDefaultLimit(), $result);
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

        /** @var Average $average */
        foreach ($result as $average) {
            self::assertInstanceOf($this->getExpectedAverageClass(), $average);
            self::assertEquals(10, $average->getValue());
        }
    }
}