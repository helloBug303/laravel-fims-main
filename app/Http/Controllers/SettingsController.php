<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

 function edit()
{
    return view('settings.edit'); // or return Inertia::render('Settings/Edit') if using Inertia
}

