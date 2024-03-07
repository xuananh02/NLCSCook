<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('c_t_nau_ans', function (Blueprint $table) {
            $table->bigIncrements('MaCT');
            $table->unsignedBigInteger('MaND');
            $table->string('TenMonAn');
            $table->string('MoTa');
            $table->text('MoTaChiTiet');
            $table->string('TenTheLoai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_t_nau_ans');
    }
};
