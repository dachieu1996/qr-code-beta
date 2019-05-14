<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class STT_LoSX extends Model
{
    //
    protected $table = 'stt_losx';
    protected $primaryKey = 'STT';

    public function losx(){
        return $this->belongsTo('App\LoSX','MaLo','MaLo');
    }

    public function daily(){
        return $this->belongsTo('App\DaiLy','MaDL','MaDL');
    }
}
