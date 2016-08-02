<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Measurement\Statistics\AverageFactory;
use Assert\Assertion;
use Illuminate\Http\Request;

/**
 * Class AverageController
 * @package App\Http\Controllers\API
 */
abstract class AverageController extends Controller
{
    /**
     * @var AverageFactory
     */
    private $factory;

    /**
     * AverageController constructor.
     * @param AverageFactory $averageFactory
     */
    public function __construct(AverageFactory $averageFactory)
    {
        $this->factory = $averageFactory;
    }

    /**
     * @return int
     */
    abstract public function getDefaultLimit() : int;

    /**
     * @param Request $request
     * @return array
     */
    public function get(Request $request) : array
    {
        $limit = $request->get('limit') ?: $this->getDefaultLimit();
        Assertion::integer($limit);

        return $this->factory->getAverages($limit);
    }
}