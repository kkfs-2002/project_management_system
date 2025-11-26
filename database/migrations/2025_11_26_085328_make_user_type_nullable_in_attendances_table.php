<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Make user_type nullable (core fix)
            $table->string('user_type')->nullable()->change();  // Adjust 'string' if it's enum/int

            // Optional: Drop old FK/index if exists
            // $table->dropForeign(['user_type']);  // Uncomment if FK present
        });

        // Optional: Set existing records to NULL (if any)
        DB::statement('UPDATE attendances SET user_type = NULL WHERE user_type IS NOT NULL;');
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Revert to NOT NULL
            $table->string('user_type')->nullable(false)->change();
        });
    }
};