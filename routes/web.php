<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name("welcome");

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get("schedule", function(){
        return view("schedule.index");
    })->name("schedule");

    Route::get("environments", function(){
        return view("environments.index");
    })->name("environments");

    Route::get("implements/{id}", function($id){ 
        return view("implements.index", ['id' => $id]);
    })->name("implements");
    
    Route::get("users", function(){ 
        return view("users.index");
    })->name("users");


    
    // Route::controller(EnvironmentsController::class)->group(function(){
        // Route::get("environments", 'render')->name("environments");
    // });
});
