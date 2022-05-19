<?php

namespace App\Http\Controllers\Docs;

use Illuminate\View\View;
use App\Http\Controllers\Controller;

class WelcomeController extends Controller
{
    public function welcome(): View
    {
        return view('welcome');
    }
}
