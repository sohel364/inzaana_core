<?php

namespace Inzaana\Http\Controllers;

use Illuminate\Http\Request;

use Inzaana\Http\Requests;

class SuperAdminController extends Controller
{
    public function index()
    {
        return view('super-admin.dashboard');
    }
}
