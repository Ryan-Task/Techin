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
        Schema::create('service_details', function (Blueprint $table) {
            $table->id();

            // Relasi ke service_requests (pakai service_id)
            $table->string('service_id');
            $table->foreign('service_id')
                  ->references('service_id')
                  ->on('service_requests')
                  ->onDelete('cascade');

            $table->string('nama_sparepart')->nullable(); 
            $table->decimal('harga_sparepart', 12, 2)->default(0);
            $table->decimal('harga_jasa', 12, 2)->default(0);
            $table->decimal('total_biaya', 12, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_details');
    }
};