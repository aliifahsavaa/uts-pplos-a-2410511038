<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
     {
        if (!Schema::hasTable('fasilitas')) {
            Schema::create('fasilitas', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('kamar_id');
                $table->string('nama_fasilitas', 100);
                $table->text('deskripsi')->nullable();
                $table->timestamps();
                $table->foreign('kamar_id')->references('id')->on('kamar');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fasilitas');
    }
};
