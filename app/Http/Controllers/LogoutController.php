<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function store()
    {
        auth()->logout();
        auth()->user()->tokens()->delete();

        return redirect()->route("home.index");
    }
}
