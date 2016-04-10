<?php

namespace Http\Controllers;

use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function request()
    {
        return view('registration.request');
    }

    public function submitRequest(Request $request)
    {
        return back()->withInput();
    }
}