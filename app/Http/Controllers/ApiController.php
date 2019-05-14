<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    public function postHinhAnh(Request $request){
        if($request->hasFile('HinhAnh')){
            //lưu hình ảnh
            $HinhAnh = $request->file('HinhAnh');
            $HinhAnh->move('upload/sanpham',$request->file('HinhAnh')->getClientOriginalName());
        }
    }
}
