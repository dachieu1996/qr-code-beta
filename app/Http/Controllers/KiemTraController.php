<?php

namespace App\Http\Controllers;

use App\LoSX;
use App\SanPham;
use App\SP_LoSX;
use App\STT_LoSX;
use App\DaiLy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

class KiemTraController extends Controller
{
    //
    public function postKiemTra(Request $request)
    {
        try{
            $data = $request->Data;
            // giải mã Data
            $data = decrypt($data);
            // json_decode Data
            $data = json_decode($data);
            
            $MaLo = $data->MaLo;
            $MaSP = $data->MaSP;
            $STT = $data->STT;

            $sp_losx = SP_LoSX::where('MaLo',$MaLo)->where('MaSP',$MaSP)->first();
            $TenDL = STT_LoSX::where('MaLo',$MaLo)->where('MaSP',$MaSP)->where('STT',$STT)->first()->daily->TenDL;
            $sanpham = SanPham::where('MaSP',$MaSP)->first();

            $result['TenSP'] = $sanpham->TenSP;
            $result['HinhAnh'] = $sanpham->HinhAnh;
            $result['SDK'] = $sanpham->SDK;
            $result['MaLo'] = $MaLo;
            $result['NSX'] = $sp_losx->NSX->format('d/m/Y');
            $result['HSD'] = $sp_losx->HSD->format('d/m/Y');
            $result['TenDL'] = $TenDL;
            $result['NhaSX'] = env('APP_NAME');

            $result = json_encode($result);
            return response($result,200);
	    }catch (\Exception $e){
            return response('Sản phẩm chưa được xác thực!',400);
        };

    }
    public function getThongTin($MaLo){
        $count = SP_LoSX::where('MaLo',$MaLo)->count();
        if($count == 0){
            return response(null,404);
        }

        //Lấy thông tin về sản phẩm và lô sản xuất
        $sp_losx = \App\SP_LoSX::where('MaLo',$MaLo)->get();
        foreach ($sp_losx as $losx){
            $sanpham = \App\SanPham::where('MaSP',$losx->MaSP)->first();
            $MaSP = $losx->MaSP;

            $thongtin[$MaSP]['IP'] = $_SERVER['SERVER_ADDR'];
            $thongtin[$MaSP]['MaLo'] = $losx->MaLo;
            $thongtin[$MaSP]['MaSP'] = $losx->MaSP;
            $thongtin[$MaSP]['TenSP'] = $sanpham->TenSP;
            $thongtin[$MaSP]['SDK'] = $sanpham->SDK;
            $thongtin[$MaSP]['HinhAnh'] = $sanpham->HinhAnh;
            $thongtin[$MaSP]['NSX'] = $losx->NSX->format('d/m/Y');
            $thongtin[$MaSP]['HSD'] = $losx->HSD->format('d/m/Y');
            $thongtin[$MaSP]['SoLuong'] = $losx->SoLuong;

            //Lấy thông tin các đại lý phân phối
            $stt_losx = DB::select( DB::raw("select MaDL, count(STT) as SoSP from stt_losx where MaLo = '$MaLo' and MaSP = '$MaSP' group by MaDL order by STT ASC ") );
            $i = 0;
            foreach ($stt_losx as $stt){
                $thongtin[$MaSP]['MaDL'][$i] = $stt->MaDL;
                $thongtin[$MaSP]['TenDL'][$i] = DaiLy::where('MaDL',$stt->MaDL)->first()->TenDL;
                $thongtin[$MaSP]['SoSP'][$i] = $stt->SoSP;

                $i++;
            }
        }
        $data = json_encode($thongtin);
        $data = encrypt($data);
        return response(['Data'=>$data],200);
    }

}
