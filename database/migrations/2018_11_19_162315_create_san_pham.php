<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSanPham extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('sanpham', function (Blueprint $table) {
            $table->string('MaSP');
            $table->string('TenSP');
            $table->string('SDK');
            $table->string('HinhAnh');
            $table->string('MoTa')->nullable();
            $table->string('Gia')->nullable();
            $table->timestamps();
            $table->primary('MaSP');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('SanPham');
    }
}
