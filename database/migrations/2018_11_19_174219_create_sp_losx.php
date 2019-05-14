<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpLosx extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sp_losx', function (Blueprint $table) {
            $table->string('MaLo');
            $table->string('MaSP');
            $table->date('NSX');
            $table->date('HSD');
            $table->integer('SoLuong');
            $table->timestamps();
            $table->primary(['MaSP','MaLo']);
            $table->foreign('MaSP')->references('MaSP')->on('sanpham');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('SP_LoSX');
    }
}
