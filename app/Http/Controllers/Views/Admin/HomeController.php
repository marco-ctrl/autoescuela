<?php

namespace App\Http\Controllers\Views\Admin;

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
        return view('admin.index', compact('cards'));
    }
}
