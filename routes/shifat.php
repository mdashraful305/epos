<?php


Route::get('/test', function () {
    return redirect()->route('dashboard');
});
