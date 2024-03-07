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
        Schema::create('hinh_anhs', function (Blueprint $table) {
            $table->bigIncrements('MaHinhAnh');
            $table->string('Nguon');
            $table->timestamps();
        });
        Schema::create('hinh_anh_c_t_nau_an', function (Blueprint $table) {
            $table->bigInteger('MaHinhAnh');
            $table->unsignedBigInteger('MaCT');
            $table->primary(['MaCT', 'MaHinhAnh']);
        });
        Schema::create('hinh_anh_the_loai', function (Blueprint $table) {
            $table->bigInteger('MaHinhAnh');
            $table->string('TenTheLoai');
            $table->primary(['TenTheLoai', 'MaHinhAnh']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hinh_anhs');
    }
};
