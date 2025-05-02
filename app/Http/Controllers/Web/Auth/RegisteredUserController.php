<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     * 
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }
}
