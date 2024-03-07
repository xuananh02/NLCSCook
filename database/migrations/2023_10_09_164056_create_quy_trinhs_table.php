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
        Schema::create('quy_trinhs', function (Blueprint $table) {
            $table->bigIncrements('MaQT');
            $table->unsignedBigInteger('MaCT');
            $table->string('ThoiGian');
            $table->text('NoiDungBuoc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quy_trinhs');
    }
};
