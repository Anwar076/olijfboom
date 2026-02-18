<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->boolean('dua_request_enabled')->default(false)->after('paid_at');
            $table->text('dua_request_text')->nullable()->after('dua_request_enabled');
            $table->timestamp('dua_fulfilled_at')->nullable()->after('dua_request_text');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['dua_fulfilled_at', 'dua_request_text', 'dua_request_enabled']);
        });
    }
};

