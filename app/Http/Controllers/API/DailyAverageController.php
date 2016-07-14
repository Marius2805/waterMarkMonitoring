<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Measurement\DailyAverageFactory;
use Assert\Assertion;
use Illuminate\Http\Request;

/**
 * Class DailyAverageController
 * @package App\Http\Controllers\API
 */
class DailyAverageController extends Controller
{
    const DEFAULT_LIMIT = 7;

    /**
     * @var DailyAverageFactory
     */
    private $factory;

    /**
     * DailyAverageController constructor.
     * @param DailyAverageFactory $factory
     */
    public function __construct(DailyAverageFactory $factory = null)
    {
        $this->factory = $factory ?: new DailyAverageFactory();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function get(Request $request) : array
    {
        $limit = $request->get('limit') ?: self::DEFAULT_LIMIT;
        Assertion::integer($limit);

        return $this->factory->getAverages($limit);
    }
}