<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminCreate;


Route::get('/', function () {
    if (env('APP_SETUP') == false) {
        return redirect('/setup');
    }
    return view('welcome');

});


Route::get('/setup', function () {
    return view('setup');
});


Route::post('/next-setup-step', function () {
    $appUrl = request('app_url');
    if ($appUrl) {
        // Save the APP_URL to settings.json file lcated in  storage/app/settings.json

        $settingsFile = storage_path('app/public/settings.json');
        if (!file_exists($settingsFile)) {
            file_put_contents($settingsFile, json_encode([]));
        }
        $settings = json_decode(file_get_contents($settingsFile), true);
        $settings['APP_URL'] = $appUrl;
        file_put_contents($settingsFile, json_encode($settings, JSON_PRETTY_PRINT));
    }
    return redirect('/admin-setup');
});

Route::get('/admin-setup', function () {
    return view('admin-setup');
});

// setup admin-create route with cntroller
Route::post('/AdminCreate',  [AdminCreate::class, 'AdminCreate']);

Route::get('/AdminSecurity', function () {
    return view('admin-security');
});