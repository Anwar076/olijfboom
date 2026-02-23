<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
        });
        DB::statement('ALTER TABLE donations MODIFY team_id BIGINT UNSIGNED NULL');
        Schema::table('donations', function (Blueprint $table) {
            $table->foreign('team_id')->references('id')->on('teams')->nullOnDelete();
            $table->string('donor_name', 255)->nullable()->after('amount');
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropForeign(['team_id']);
            $table->dropColumn('donor_name');
        });
        DB::statement('ALTER TABLE donations MODIFY team_id BIGINT UNSIGNED NOT NULL');
        Schema::table('donations', function (Blueprint $table) {
            $table->foreign('team_id')->references('id')->on('teams')->cascadeOnDelete();
        });
    }
};
