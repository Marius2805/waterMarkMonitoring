<?php
namespace App\Http\Controllers\API;

use App\Services\Measurement\Measurement;
use App\Services\Measurement\MeasurementRepository;
use Illuminate\Http\Request;
use Tests\App\Services\Measurement\MeasurementRepositoryMock;
use Tests\TestCase;

/**
 * Class Measurement
 * @package App\Http\Controllers\API
 */
class MeasurementControllerTest extends TestCase
{
    /**
     * @var MeasurementController
     */
    private $controller;

    /**
     * @var MeasurementRepository
     */
    private $repository;

    public function setUp()
    {
        parent::setUp();

        $repositoryMock = new MeasurementRepositoryMock();
        $this->repository = $repositoryMock->getRepository();
        $this->controller = new MeasurementController($this->repository);
    }

    public function test_create_valueSavedCorrectly()
    {
        $data = ['value' => 10.33];
        $this->controller->create($this->getRequest($data));

        $result = $this->repository->getById(0);
        self::assertInstanceOf(Measurement::class, $result);
        self::assertEquals($data['value'], $result->value);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Value "<NULL>" is not a float.
     */
    public function test_create_valueMissing()
    {
        $this->controller->create($this->getRequest([]));
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Value "noFloat" is not a float.
     */
    public function test_create_valueNotFloat()
    {
        $data = ['value' => 'noFloat'];
        $this->controller->create($this->getRequest($data));
    }

    /**
     * @param array $data
     * @return Request
     */
    private function getRequest(array $data) : Request
    {
        return new Request([], [], [], [], [], [], json_encode($data));
    }
}