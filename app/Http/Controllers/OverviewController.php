<?php
namespace App\Http\Controllers;

use App\Services\Measurement\Measurement;
use Carbon\Carbon;
use Illuminate\View\View;

/**
 * Class OverviewController
 * @package App\Http\Controllers
 */
class OverviewController extends Controller
{
    /**
     * @return View
     */
    public function overview() : View
    {
        /** @var Measurement $lastMeasurement */
        $lastMeasurement = Measurement::orderBy('created_at', 'desc')->first();
        $data = [
            'lastMeasurementValue'  => round($lastMeasurement->value, 2),
            'lastMeasurementOffset' => Carbon::now()->diffInMinutes($lastMeasurement->created_at)
        ];

        return view('overview', $data);
    }
}