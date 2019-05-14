<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSttLosx extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('stt_losx',function (Blueprint $table){
            $table->string('MaLo');
            $table->string('MaSP');
            $table->integer('STT');
            $table->string('MaDL');
            $table->timestamps();
            $table->primary(['MaLo','MaSP','STT']);
            $table->foreign('MaDL')->references('MaDL')->on('daily');
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
    }
}
