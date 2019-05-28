<?php

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
Route::group(['prefix'=>'admin', 'middleware'=>'auth'],function (){

    Route::get('/','LoSXController@getDanhSach');
    Route::group(['prefix'=>'losanxuat'],function (){
        Route::get('danhsach','LoSXController@getDanhSach');
        Route::get('them','LoSXController@getThem');
        Route::post('them','LoSXController@postThem');
        Route::get('chitiet/{MaLo}/{MaSP}','LoSXController@getChiTiet');
        Route::get('sua/{MaLo}/{MaSP}','LoSXController@getSua');
        Route::post('sua','LoSXController@postSua');
        Route::get('xoa/{MaLo}/{MaSP}','LoSXController@getXoa');
    });

    Route::group(['prefix'=>'sanpham'],function (){
        Route::get('danhsach','SanPhamController@getDanhSach');
        Route::get('them','SanPhamController@getThem');
        Route::post('them','SanPhamController@postThem');
        Route::get('sua/{MaSP}','SanPhamController@getSua');
        Route::post('sua/{MaSP}','SanPhamController@postSua');
        Route::get('xoa/{MaSP}','SanPhamController@getXoa');
    });

    Route::group(['prefix'=>'daily'],function (){
        Route::get('danhsach','DaiLyController@getDanhSach');
        Route::get('them','DaiLyController@getThem');
        Route::post('them','DaiLyController@postThem');
        Route::get('sua/{MaDL}','DaiLyController@getSua');
        Route::post('sua/{MaDL}','DaiLyController@postSua');
    });

    Route::group(['prefix'=>'ajax'],function (){
        Route::get('TenSP/{MaLo}','AjaxController@getTenSP');
        Route::get('LoSanXuat/{MaLo}/{MaSP}','AjaxController@getLoSanXuat');
        Route::get('SanPham/{MaSP}','AjaxController@getSanPham');
        Route::get('SP_LoSX/{MaLo}/{MaSP}','AjaxController@getError');
    });
});

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');
