<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('kiemtra','KiemTraController@postKiemTra');

Route::get('thongtin/{MaLo}','KiemTraController@getThongTin');

Route::post('postHinhAnh','ApiController@postHinhAnh');