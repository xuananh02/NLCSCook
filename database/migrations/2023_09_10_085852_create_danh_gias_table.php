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
        Schema::create('danh_gias', function (Blueprint $table) {
            $table->bigIncrements('MaDanhGia');
            $table->unsignedBigInteger('MaCT');
            $table->unsignedBigInteger('MaND');
            $table->text('BinhLuan');
            $table->timestamps();
        });
        Schema::create("phan_hoi", function (Blueprint $table) {
            $table->bigIncrements('MaPhanHoi');
            $table->string('Email');
            $table->string('Ten');
            $table->string('ChuDe');
            $table->text('BinhLuan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('danh_gias');
    }
};
