<?php
namespace App\Http\Controllers;

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
        return view('overview');
    }
}