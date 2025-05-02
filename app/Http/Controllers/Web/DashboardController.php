<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Display the dashboard view.
     * 
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Dashboard/Dashboard');
    }
}
