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
    Schema::create('service_requests', function (Blueprint $table) {
        $table->id();
        $table->string('service_id')->unique();
        $table->string('nama_pelanggan');
        $table->string('no_wa');
        $table->string('email')->nullable();
        $table->enum('jenis_barang', ['HP', 'Laptop', 'PC', 'Tablet', 'TV', 'Lainnya']);
        $table->string('nama_barang');
        $table->text('kerusakan');
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_requests');
    }
};