<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Country;

Route::get('/countries', function () {
    $countries = Country::orderBy('name', 'asc')->get(['id', 'name']);
    return response()->json($countries);
});
