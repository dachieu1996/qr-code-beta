<?php

namespace App\Http\Controllers;

use App\LoSX;
use App\SanPham;
use App\SP_LoSX;
use Illuminate\Http\Request;

class AjaxController extends Controller
{

    public function getSanPham($MaSP){
        $count = SanPham::where('MaSP',$MaSP)->count();
        if($count != 0){
            $sanpham = SanPham::where('MaSP',$MaSP)->first();
            return response($sanpham,200);
        }
        else return response(null,404);

    }

    public function getLoSanXuat($MaLo,$MaSP){
        $sp_losx = SP_LoSX::where('MaLo',$MaLo)->where('MaSP',$MaSP)->first();
        $data['NSX'] = $sp_losx->NSX->format('Y-m-d');
        $data['HSD'] = $sp_losx->HSD->format('Y-m-d');
        $data['SoLuong'] = $sp_losx->SoLuong;
        return response($sp_losx);
    }
    public function getError($MaLo,$MaSP){
        $count = SP_LoSX::where('MaLo',$MaLo)->where('MaSP',$MaSP)->count();
        if($count!=0) return response('<p style="color: #b92c28">* Đã tồn tại mã sản phẩm '.strtoupper($MaSP).' trong lô '.$MaLo.'</p>',200) ;
        else return response("",404);
    }

    public function getTenSP($MaLo){
        $sp_losx = SP_LoSX::where('MaLo',$MaLo)->get();
        foreach ($sp_losx as $sp){
            echo "<option value='".$sp->MaSP."'>".$sp->MaSP."</option>";
        }
    }
    public function postSanPham(Request $request){
        $MaSP = $request->MaSP;
        $TenSP = $request->TenSP;
        $SDK = $request->SDK;


        $count = SanPham::where('MaSP',$MaSP)->count();
        if($count == 0){
            $sanpham = new SanPham();
            $sanpham->MaSP = $MaSP;
            $sanpham->TenSP = $TenSP;
            $sanpham->SDK = $SDK;
            $sanpham->HinhAnh = trim($request->file('HinhAnh')->getClientOriginalName());
            //lưu hình ảnh
            $HinhAnh = $request->file('HinhAnh');
            $HinhAnh->move('upload/sanpham',$request->file('HinhAnh')->getClientOriginalName());
            //lưu sản phẩm
            $sanpham->save();
        }
        else{
            $sanpham = SanPham::where('MaSP',$MaSP);
            $sanpham->TenSP = $TenSP;
            $sanpham->SDK = $SDK;
            if($request->HinhAnh!=null){
                $sanpham->HinhAnh = trim($request->file('HinhAnh')->getClientOriginalName());
                //lưu hình ảnh
                $HinhAnh = $request->file('HinhAnh');
                $HinhAnh->move('upload/sanpham',$request->file('HinhAnh')->getClientOriginalName());
            }
            $sanpham->save();
        }
    }



}
