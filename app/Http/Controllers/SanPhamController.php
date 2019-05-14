<?php

namespace App\Http\Controllers;

use App\DaiLy;
use App\LoSX;
use App\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SanPhamController extends Controller
{
    public function getDanhSach(){
        $sanpham = SanPham::all();
        return view('admin.sanpham.danhsach',['sanpham'=>$sanpham]);
    }

    public function getThem(){
        return view('admin.sanpham.them');
    }

    public function postThem(Request $request){
        $this->validate($request,
            [
                'MaSP' => 'required|unique:sanpham,MaSP',
                'TenSP' => 'required',
                'SDK' => 'required',
                'HinhAnh' => 'required',
            ],
            [
                'MaSP.required'=>'Chưa nhập Mã Sản Phẩm',
                'MaSP.unique'=>'Mã sản phẩm đã tồn tại',

                'TenSP.required'=>'Chưa nhập Tên Sản Phẩm',

                'SDK.required'=>'Chưa nhập Số Đăng Ký',

                'HinhAnh.required' => 'Chưa nhập Hình Ảnh',
            ]);
        try{
            $sanpham = new SanPham();
            $sanpham->MaSP = strtoupper(trim($request->MaSP));
            $sanpham->TenSP = trim($request->TenSP);
            $sanpham->SDK = trim($request->SDK);
            $sanpham->HinhAnh = trim($request->file('HinhAnh')->getClientOriginalName());
            //lưu hình ảnh
            $HinhAnh = $request->file('HinhAnh');
            $HinhAnh->move('upload/sanpham',$request->file('HinhAnh')->getClientOriginalName());
            $sanpham->save();
        }catch (\Exception $e){
            return redirect('admin/sanpham/them')->with('canhbao','Có lỗi xảy')->withInput();
        };

        return redirect('admin/sanpham/danhsach')->with('thongbao','Thêm Thành Công Mã Sản Phẩm '.$request->MaSP);
    }

    public function getSua($MaSP){
        $sanpham = SanPham::where('MaSP','=',$MaSP)->first();
        return view('admin/sanpham/sua',['sanpham'=>$sanpham]);
    }

    public function postSua($MaSP,Request $request){
        $sanpham = SanPham::where('MaSP','=',$MaSP)->first();
        $this->validate($request,
            [
                'MaSP' => 'required|exists:sanpham,MaSP',
                'TenSP' => 'required',
                'SDK' => 'required',
            ],
            [
                'MaSP.required'=>'Chưa nhập Mã Sản Phẩm',
                'MaSP.exists'=>'Không tồn tại Mã Sản Phẩm này',

                'TenSP.required'=>'Chưa nhập Tên Sản Phẩm',

                'SDK.required'=>'Chưa nhập Số Đăng Ký',
            ]);

        try{
            $sanpham->TenSP = trim($request->TenSP);
            $sanpham->SDK = trim($request->SDK);
            if($request->hasFile('HinhAnh')){
                $sanpham->HinhAnh = $request->file('HinhAnh')->getClientOriginalName();
                //lưu hình ảnh
                $HinhAnh = $request->file('HinhAnh');
                $HinhAnh->move('upload/sanpham',$request->file('HinhAnh')->getClientOriginalName());
            }
            $sanpham->save();
            return redirect('admin/sanpham/danhsach')->with('thongbao','Sửa Thành Công Mã Sản Phẩm '.$MaSP);
        } catch (\PDOException $e){
            return Redirect::to('admin/sanpham/sua/'.$MaSP)->with('canhbao','Đã xảy ra lỗi!')->withInput();
        }
    }

    public function getXoa($MaSP){
        try{
            SanPham::where('MaSP',$MaSP)->delete();
            return \redirect('admin/sanpham/danhsach')->with('thongbao','Xóa thành công Mã Sản Phẩm '.$MaSP);
        }catch (\PDOException $PDOException){
            return \redirect('admin/sanpham/danhsach')->with('nguyhiem','Cần xóa hết các Lô có chứa mã sản phẩm '.$MaSP.' trước khi xóa sản phẩm!');
        }
    }

}
