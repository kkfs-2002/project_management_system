<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;  // For optional update

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Make user_id nullable (core fix)
            $table->unsignedBigInteger('user_id')->nullable()->change();

            // Optional: Drop old foreign key if it exists (uncomment if needed)
            // $table->dropForeign(['user_id']);
        });

        // Optional: Set existing records' user_id to NULL (if any records exist)
        DB::statement('UPDATE attendances SET user_id = NULL WHERE user_id IS NOT NULL;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Revert to NOT NULL (for rollback)
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};