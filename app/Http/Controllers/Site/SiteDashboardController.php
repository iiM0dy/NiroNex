<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SiteDashboardController extends Controller
{
    public function index()
    {
        return view('site.dashboard');
    }
}
