<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/documentation', function () {
    $documentation = 'default';

    return response()->view('l5-swagger::index', [
        'documentation' => $documentation,
        'urlToDocs' => url('docs/api-docs.json'),
        'operationsSorter' => config('l5-swagger.defaults.operations_sort'),
        'configUrl' => config('l5-swagger.defaults.additional_config_url'),
        'validatorUrl' => config('l5-swagger.defaults.validator_url'),
    ]);
})->name('l5-swagger.default.api');

Route::get('/docs/api-docs.json', function () {
    $filePath = storage_path('api-docs/api-docs.json');

    if (!file_exists($filePath)) {
        abort(404, 'API documentation file not found. Please run: php artisan l5-swagger:generate');
    }

    return response()->file($filePath, [
        'Content-Type' => 'application/json',
    ]);
})->name('l5-swagger.default.docs');
