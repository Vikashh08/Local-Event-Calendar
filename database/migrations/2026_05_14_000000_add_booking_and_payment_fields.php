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
        Schema::table('events', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->nullable()->default(0)->after('capacity');
        });

        Schema::table('rsvps', function (Blueprint $table) {
            $table->string('payment_status')->default('free')->after('status');
            $table->string('payment_method')->nullable()->after('payment_status');
            $table->string('payment_id')->nullable()->after('payment_method');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('price');
        });

        Schema::table('rsvps', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'payment_method', 'payment_id']);
        });
    }
};
