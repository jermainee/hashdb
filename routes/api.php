<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/password/pwned', function (Request $request) {
    return ['pwned' => DB::table('passwords')->where('value', '=', $request->get('password'))->exists()];
});

Route::post('/hash/pwned', function (Request $request) {
    return ['pwned' => DB::table('hash')->where('hash', '=', $request->get('hash'))->exists()];
});
