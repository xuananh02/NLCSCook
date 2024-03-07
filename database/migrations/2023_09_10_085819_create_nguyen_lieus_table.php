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
        Schema::create('nguyen_lieus', function (Blueprint $table) {
            $table->bigIncrements("MaNL");
            $table->string('TenNguyenLieu');
            $table->integer('SoLuong');
            $table->string('DonVi');
            $table->unsignedBigInteger('MaCT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nguyen_lieus');
    }
};
