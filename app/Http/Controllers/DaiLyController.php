<?php

namespace App\Http\Controllers;

use App\DaiLy;
use Illuminate\Http\Request;

class DaiLyController extends Controller
{
    //
    public function getDanhSach(){
        $daily = DaiLy::all();
        return view('admin.daily.danhsach',['daily'=>$daily]);
    }
    public function getSua($MaDL){
        $daily = DaiLy::where('MaDL',$MaDL)->first();
        return view('admin.daily.sua',['daily'=>$daily]);
    }
    public function postSua($MaDL, Request $request){
        $this->validate($request,
            [
                'MaDL' => 'required|exists:daily,MaDL',
                'TenDL' => 'required',
            ],
            [
                'MaDL.required'=>'Chưa nhập Mã Đại Lý',
                'MaDL.exists'=>'Không tồn tại Mã Đại Lý này',

                'TenDL.required'=>'Chưa nhập Tên Đại Lý',
            ]);
        $daily = DaiLy::where('MaDL',$MaDL)->first();
        try{
            $daily->TenDL = trim($request->TenDL);
            $daily->save();
            return redirect('admin/daily/sua/'.$MaDL)->with('thongbao','Sửa Thành Công');
        }catch (\PDOException $PDOException){
            return Redirect::to('admin/daily/sua/'.$MaDL)->with('canhbao','Đã xảy ra lỗi!');
        }
    }

    public function getThem(){
        return view('admin.daily.them');
    }

    public function postThem(Request $request){
        $this->validate($request,
            [
                'MaDL' => 'required|unique:daily,MaDL',
                'TenDL' => 'required',
            ],
            [
                'MaDL.required'=>'Chưa nhập Mã Đại Lý',
                'MaDL.unique'=>'Mã Đại lý đã tồn tại',

                'TenDL.required'=>'Chưa nhập Tên Đại Lý',

            ]);
        try{
            $daily = new DaiLy();
            $daily->MaDL = strtoupper(trim($request->MaDL));
            $daily->TenDL = trim($request->TenDL);
            $daily->save();
        }catch (\PDOException $e){
            return redirect('admin/daily/them')->with('canhbao','Có lỗi xảy')->withInput();
        };


        return redirect('admin/daily/danhsach')->with('thongbao','Thêm Thành Công');
    }
}
