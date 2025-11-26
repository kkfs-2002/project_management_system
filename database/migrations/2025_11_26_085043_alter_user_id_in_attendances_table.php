<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Make user_id nullable (or dropColumn if no legacy data)
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Optional: If you want to drop it entirely (after backing up data)
            // $table->dropColumn('user_id');
            
            // Optional: Drop old FK if it exists
            // $table->dropForeign(['user_id']);
        });
    }

    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            // Revert to NOT NULL (or recreate column)
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
        });
    }
};