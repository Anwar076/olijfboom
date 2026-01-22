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
            $table->string('status', 20)->default('pending')->after('amount');
            $table->string('mollie_payment_id', 100)->nullable()->unique()->after('status');
            $table->timestamp('paid_at')->nullable()->after('mollie_payment_id');
        });

        DB::table('donations')->update([
            'status' => 'paid',
            'paid_at' => DB::raw('created_at'),
        ]);
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            $table->dropColumn(['paid_at', 'mollie_payment_id', 'status']);
        });
    }
};
