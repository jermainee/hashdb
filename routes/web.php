<?php

use Illuminate\Support\Facades\DB;
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
    return view('welcome', [
        'hashes' => DB::table('hashes')->orderBy('updated_at', 'desc')->paginate(50),
    ]);
});

Route::get('/password/{password}', function (string $password) {
    $password  = DB::table('passwords')->where('value', '=', $password)->first();

    if (!$password) {
        return redirect('/');
    }

    return view('password', [
        'hash' => null,
        'algorithm' => null,
        'password' => $password,
        'hashes' => DB::table('hashes')->where('password_id', '=', $password->id)->orderBy('algorithm')->paginate(50),
    ]);
});

Route::get('/hash/{hash}', function (string $hash) {
    $hash  = DB::table('hashes')->where('hash', '=', $hash)->first();

    if (!$hash) {
        return redirect('/');
    }

    return view('password', [
        'hash' => $hash->hash,
        'algorithm' => null,
        'hashes' => DB::table('hashes')->where('password_id', '=', $hash->password_id)->inRandomOrder()->paginate(50),
        'password' => DB::table('passwords')->where('id', '=', $hash->password_id)->first(),
    ]);
});

Route::get('/algorithm/{algorithm}', function (string $algorithm) {
    $hashes = DB::table('hashes')->where('algorithm', '=', $algorithm)->orderBy('updated_at', 'desc')->paginate(50);

    if ($hashes->isEmpty()) {
        return redirect('/');
    }

    return view('password', [
        'hash' => null,
        'algorithm' => $algorithm,
        'hashes' => $hashes,
        'password' => null,
    ]);
});

Route::get('/collisions', function () {
    $hashes = DB::table('hashes')->groupBy('hash')->having(DB::raw('count(hash)'), '>', 1)->paginate(50);

    return view('password', [
        'hash' => null,
        'algorithm' => null,
        'hashes' => $hashes,
        'password' => null,
    ]);
});
