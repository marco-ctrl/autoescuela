<?php

namespace App\Http\Controllers\Views\Manager;

use App\Http\Controllers\Controller;
use App\Services\DashboardAdmin;

class HomeController extends Controller
{
    public $dashboardAdmin;

    public function __construct(DashboardAdmin $dashboardAdmin){
        $this->dashboardAdmin = $dashboardAdmin;
    }

    public function index()
    {
        //datos cards
        $cards = $this->dashboardAdmin->getData();
        //$pieGraphic = $this->dashboardAdmin->getDataPie();
        return view('manager.index', compact('cards'));
    }
}
