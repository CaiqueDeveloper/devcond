<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/ping', function(){
    return ['ping' => true];
});