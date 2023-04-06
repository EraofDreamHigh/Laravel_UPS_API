<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('fedex')->name('fedex.')->namespace('Fedex')->group(function () {
    Route::get('track', function(App\Http\Transporters\Services\Fedex\Track\Example $example) { return $example->getTrack(); });
    Route::get('rates', function(App\Http\Transporters\Services\Fedex\Rate\Example $example) { return $example->getRates(); });
    Route::get('pickup', function(App\Http\Transporters\Services\Fedex\Pickup\Example $example) { return $example->createPickup(); });
    Route::get('shipment', function(App\Http\Transporters\Services\Fedex\Shipment\Example $example) { return $example->createShipment(); });
});

Route::prefix('tnt')->name('tnt.')->namespace('TNT')->group(function () {
    Route::get('track', function(App\Http\Transporters\Services\TNT\Track\Example $example) { return $example->getTrack(); });
    Route::get('rates', function(App\Http\Transporters\Services\TNT\Rate\Example $example) { return $example->getRates(); });
    Route::get('pickup', function(App\Http\Transporters\Services\TNT\Pickup\Example $example) { return $example->createPickup(); });
    Route::get('shipment', function(App\Http\Transporters\Services\TNT\Shipment\Example $example) { return $example->createShipment(); });
});

Route::prefix('ups')->name('ups.')->namespace('UPS')->group(function () {
    Route::get('rates', function(App\Http\Transporters\Services\UPS\Rate\Example $example) { return $example->getRates(); });
    Route::get('rates-freight', function(App\Http\Transporters\Services\UPS\Rate\FreightExample $example) { return $example->getRates(); });
    Route::get('rates-freight2', function(App\Http\Transporters\Services\UPS\FreightRate\Example $example) { return $example->getRates(); });
});
