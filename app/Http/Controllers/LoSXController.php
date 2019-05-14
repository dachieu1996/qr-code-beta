<?php

namespace App\Http\Controllers;

use App\DaiLy;
use App\LoSX;
use App\SanPham;
use App\SP_LoSX;
use App\STT_LoSX;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use PhpParser\Node\Expr\Array_;

class LoSXController extends Controller
{

    public function getDanhSach(){
        $sp_losx = SP_LoSX::all();
        return view('admin.losx.danhsach',['sp_losx'=>$sp_losx]);
    }

    public function getChiTiet($MaLo,$MaSP){
        //Lấy thông tin về sản phẩm và lô sản xuất
        $count = SP_LoSX::where('MaSP',$MaSP)->where('MaLo',$MaLo)->count();
        if($count == 0) return \redirect('admin/losanxuat/danhsach')->with('canhbao','Không tồn tại Mã sản phẩm '.$MaSP.' trong lô hàng '.$MaLo);

        $sp_losx = SP_LoSX::where('MaSP',$MaSP)->where('MaLo',$MaLo)->first();

        $thongtin['MaLo'] = $MaLo;
        $thongtin['MaSP'] = $MaSP;
        $thongtin['TenSP'] = $sp_losx->motsanpham->TenSP;
        $thongtin['SDK'] = $sp_losx->motsanpham->SDK;
        $thongtin['HinhAnh'] = $sp_losx->motsanpham->HinhAnh;
        $thongtin['NSX'] = $sp_losx->NSX->format('d/m/Y');
        $thongtin['HSD'] = $sp_losx->HSD->format('d/m/Y');
        $thongtin['SoLuong'] = $sp_losx->SoLuong;

        //Lấy thông tin các đại lý phân phối
        $stt_losx = DB::select( DB::raw("select MaDL, count(STT) as SoSP from stt_losx where MaLo = '$MaLo' and MaSP = '$MaSP' group by MaDL order by STT ASC ") );
        $i = 0;
        foreach ($stt_losx as $stt){
            $thongtin['MaDL'][$i] = $stt->MaDL;
            $thongtin['TenDL'][$i] = DaiLy::where('MaDL',$stt->MaDL)->first()->TenDL;
            $thongtin['SoSP'][$i] = $stt->SoSP;

            $i++;
        }
        return view('admin.losx.chitiet',['thongtin'=>$thongtin]);
        return view('admin.losx.chitiet');
    }

    public function postChiTiet(Request $request){
        $this->validate($request,
            [
                'MaLo' => 'required',
                'MaSP' => 'required|exists:sanpham,MaSP',
            ],
            [
                'MaLo.required'=>'Chưa nhập Mã Lô Hàng',


                'MaSP.required'=>'Chưa nhập Mã Sản Phẩm',
                'MaSP.exists'=>'Mã sản phẩm không tồn tại',

            ]);

        //Lấy thông tin về sản phẩm và lô sản xuất
        $sanpham = SanPham::where('MaSP',$request->MaSP)->first();
        $sp_losx = SP_LoSX::where('MaSP',$request->MaSP)->where('MaLo',$request->MaLo)->first();


        $thongtin['MaLo'] = $request->MaLo;
        $thongtin['MaSP'] = $request->MaSP;
        $thongtin['TenSP'] = $sanpham->TenSP;
        $thongtin['SDK'] = $sanpham->SDK;
        $thongtin['HinhAnh'] = $sanpham->HinhAnh;
        $thongtin['NSX'] = $sp_losx->NSX->format('d/m/Y');
        $thongtin['HSD'] = $sp_losx->HSD->format('d/m/Y');
        $thongtin['SoLuong'] = $sp_losx->SoLuong;

        //Lấy thông tin các đại lý phân phối
        $stt_losx = DB::select( DB::raw("select MaDL, count(STT) as SoSP from stt_losx where MaLo = '$request->MaLo' and MaSP = '$request->MaSP' group by MaDL order by STT ASC ") );
        $i = 0;
        foreach ($stt_losx as $stt){
            $thongtin['MaDL'][$i] = $stt->MaDL;
            $thongtin['TenDL'][$i] = DaiLy::where('MaDL',$stt->MaDL)->first()->TenDL;
            $thongtin['SoSP'][$i] = $stt->SoSP;

            $i++;
        }
        return view('admin.losx.chitiet',['thongtin'=>$thongtin]);
    }

    public function getThem(){
        $daily = DaiLy::all();
        return view('admin.losx.them',['daily'=>$daily]);
    }

    public function postThem(Request $request){
        $this->validate($request,
            [
                'MaLo' => 'required',
                'MaSP' => 'required',
                'TenSP' => 'required',
                'SDK' => 'required',
                'NSX' => 'required|date',
                'HSD' => 'required|date|after:NSX',
                'SoLuong' => 'required|numeric',
                'Tong' => 'required|numeric',
            ],
            [
                'MaLo.required'=>'Chưa nhập Mã Lô Hàng',

                'MaSP.required'=>'Chưa nhập Mã Sản Phẩm',
                'TenSP.required'=>'Chưa nhập Tên Sản Phẩm',
                'SDK.required'=>'Chưa nhập Số Đăng Ký',

                'NSX.required'=>'Chưa nhập Ngày sản xuất',
                'NSX.date'=>'Trường NSX phải ở dạng ngày/tháng/năm',

                'HSD.required'=>'Chưa nhập Hạn sử dụng',
                'HSD.date'=>'Trường HSD phải ở dạng ngày/tháng/năm',
                'HSD.after'=>'Hạn sử dụng phải sau Ngày sản xuất',

                'SoLuong.required'=>'Chưa nhập Số lượng',
            ]);
        $MaLo = trim($request->MaLo);
        $MaSP = strtoupper(trim($request->MaSP));
        $TenSP = trim($request->TenSP);
        $SDK = trim($request->SDK);
        $NSX = $request->NSX;
        $HSD = $request->HSD;
        $SoLuong = $request->SoLuong;
        $Tong = $request->Tong;
        $MaDL = $request->MaDL;

        //Kiểm tra tồn tại SP_LoSX
        $countSP_LoSX = SP_LoSX::where('MaSP',$MaSP)->where('MaLo',$MaLo)->count();
        if($countSP_LoSX != 0) return \redirect('admin/losanxuat/them')->with('canhbao','Mã Sản phẩm '.$MaSP.' đã tồn tại trong lô hàng '.$MaLo);

        //Kiểm tra tồn tại sản phẩm
        $countSP = SanPham::where('MaSP',$MaSP)->where('MaSP',$MaSP)->count();
        if($countSP == 0 ){
            try{

                if(!$request->hasFile('HinhAnh')){
                    return \redirect('admin')->with('canhbao','Chưa nhập Hình ảnh')->withInput();
                }

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
            catch (\PDOException $PDOException){
                return redirect('admin/losanxuat/them')->with('canhbao','Có lỗi xảy ra')->withInput();
            }

        }

        //Kiểm tra số lượng sản phẩm đã phân phối đủ
        if($SoLuong != $Tong){
            return redirect('admin/losanxuat/them')->with('canhbao','Chưa phân phối đủ sản phẩm')->withInput();
        }





        try{
            $sp_losx = new SP_LoSX();
            $sp_losx->MaLo = $MaLo;
            $sp_losx->MaSP = $MaSP;
            $sp_losx->NSX = $NSX;
            $sp_losx->HSD = $HSD;
            $sp_losx->SoLuong = $SoLuong;
            $sp_losx->save();
        }catch (\PDOException $e){
            return redirect('admin/losanxuat/them')->with('canhbao','Có lỗi xảy ra')->withInput();
        }


        // Tạo số STT cho mỗi sản phẩm của lô
        $SoDaiLy = count($MaDL);
        $STTtu = 0;
        $STTden = 0;
        for($i = 0; $i < $SoDaiLy; $i++){
            $STTtu = $STTden + 1;
            $STTden = $STTtu + $request->SoSP[$i] - 1;
            for($j = $STTtu; $j <= $STTden; $j++){
                try{
                    $stt_losx = new STT_LoSX();
                    $stt_losx->MaLo = $MaLo;
                    $stt_losx->MaSP = $MaSP;
                    $stt_losx->STT = $j;
                    $stt_losx->MaDL = $request->MaDL[$i];
                    $stt_losx->save();
                }catch (\Exception $e){
                    return redirect('admin/losanxuat/them')->with('canhbao','Có lỗi xảy ra')->withInput();
                }
            }
        }

        return redirect('admin/losanxuat/them')->with('thongbao','Thêm Thành Công Mã Sản Phẩm '.$MaSP.' của Lô sản xuất '.$MaLo);
    }

    public function getSua($MaLo,$MaSP){
        $count = SP_LoSX::where('MaLo',$MaLo)->where('MaSP',$MaSP)->count();
        if($count != 0){
            $sp_losx = SP_LoSX::where('MaLo',$MaLo)->where('MaSP',$MaSP)->first();
            $daily = DaiLy::all();
            return view('admin.losx.sua',['sp_losx'=>$sp_losx,'daily'=>$daily]);
        }
        else return \redirect('admin/losanxuat/danhsach')->with('canhbao','Không tồn tại Mã sản phẩm '.$MaSP.' trong Lô hàng '.$MaLo);

    }

    public function postSua(Request $request){

        $MaLo = $request->MaLo;
        $MaSP = $request->MaSP;
        $NSX = $request->NSX;
        $HSD = $request->HSD;
        $SoLuong = $request->SoLuong;
        $MaDL = $request->MaDL;

        $this->validate($request,
            [
                'MaLo' => 'required',
                'MaSP' => 'required',
                'TenSP' => 'required',
                'SDK' => 'required',
                'NSX' => 'required|date',
                'HSD' => 'required|date|after:NSX',
                'SoLuong' => 'required|numeric',
                'Tong' => 'required|numeric',
            ],
            [
                'MaLo.required'=>'Chưa nhập Mã Lô Hàng',

                'MaSP.required'=>'Chưa nhập Mã Sản Phẩm',
                'TenSP.required'=>'Chưa nhập Tên Sản Phẩm',
                'SDK.required'=>'Chưa nhập Số Đăng Ký',

                'NSX.required'=>'Chưa nhập Ngày sản xuất',
                'NSX.date'=>'Trường NSX phải ở dạng ngày/tháng/năm',

                'HSD.required'=>'Chưa nhập Hạn sử dụng',
                'HSD.date'=>'Trường HSD phải ở dạng ngày/tháng/năm',
                'HSD.after'=>'Hạn sử dụng phải sau Ngày sản xuất',

                'SoLuong.required'=>'Chưa nhập Số lượng',
            ]);
        // Xóa SP_LoSX, stt_losx
        try{
            SP_LoSX::where('MaLo',$MaLo)->where('MaSP',$MaSP)->delete();
            STT_LoSX::where('MaLo',$MaLo)->where('MaSP',$MaSP)->delete();
        }catch (\PDOException $PDOException){
            \redirect('admin/losanxuat/sua/'.$MaLo.'/'.$MaSP)->with('canhbao','Có Lỗi xảy ra!');
        }

        //Sửa SP_LoSX
        try{
            $sp_losx = new SP_LoSX();
            $sp_losx->MaLo = $MaLo;
            $sp_losx->MaSP = $MaSP;
            $sp_losx->NSX = $NSX;
            $sp_losx->HSD = $HSD;
            $sp_losx->SoLuong = $SoLuong;
            $sp_losx->save();
        }catch (\PDOException $e){
            return redirect('admin/losanxuat/them')->with('canhbao','Có lỗi xảy ra')->withInput();
        }

        // Tạo số STT cho mỗi sản phẩm của lô
        $SoDaiLy = count($MaDL);
        $STTtu = 0;
        $STTden = 0;
        for($i = 0; $i < $SoDaiLy; $i++){
            $STTtu = $STTden + 1;
            $STTden = $STTtu + $request->SoSP[$i] - 1;
            for($j = $STTtu; $j <= $STTden; $j++){
                try{
                    $stt_losx = new STT_LoSX();
                    $stt_losx->MaLo = $request->MaLo;
                    $stt_losx->MaSP = $request->MaSP;
                    $stt_losx->STT = $j;
                    $stt_losx->MaDL = $request->MaDL[$i];
                    $stt_losx->save();
                }catch (\Exception $e){
                    return redirect('admin/losanxuat/sua/'.$MaLo.'/'.$MaSP)->with('canhbao','Có lỗi xảy ra')->withInput();
                }
            }
        }
        return \redirect('admin/losanxuat/danhsach')->with('thongbao','Sửa thành công Mã Sản Phẩm '.$MaSP.' của Lô sản xuất '.$MaLo);
    }
    public function getXoa($MaLo,$MaSP){
        try{
            STT_LoSX::where('MaLo',$MaLo)->where('MaSP',$MaSP)->delete();
            SP_LoSX::where('MaLo',$MaLo)->where('MaSP',$MaSP)->delete();
            return \redirect('admin/losanxuat/danhsach')->with('thongbao','Xóa thành công Mã Sản Phẩm '.$MaSP.' của Lô sản xuất '.$MaLo);
        }catch (\PDOException $PDOException){
            return \redirect('admin/losanxuat/danhsach')->with('canhbao','Có lỗi xảy ra!');
        }
    }
}
