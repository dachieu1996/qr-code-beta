<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SP_LoSX extends Model
{
    //
    protected $table = 'sp_losx';
    protected $primaryKey = ['MaLo', 'MaSP'];
    public $incrementing = false;
    protected $dates = ['HSD','NSX'];
    public function sanpham(){
        return $this->hasMany('App\SanPham','MaSP','MaSP');
    }

    public function motsanpham(){
        return $this->hasOne('App\SanPham','MaSP','MaSP');
    }
}
