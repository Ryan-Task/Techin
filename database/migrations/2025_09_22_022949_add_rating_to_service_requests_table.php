<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('service_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('service_requests', 'rating')) {
                $table->unsignedTinyInteger('rating')->nullable()->after('status');
            }
            if (!Schema::hasColumn('service_requests', 'ulasan')) {
                $table->text('ulasan')->nullable()->after('rating');
            }
        });
    }

    public function down(): void {
        Schema::table('service_requests', function (Blueprint $table) {
            if (Schema::hasColumn('service_requests', 'rating')) {
                $table->dropColumn('rating');
            }
            if (Schema::hasColumn('service_requests', 'ulasan')) {
                $table->dropColumn('ulasan');
            }
        });
    }
};