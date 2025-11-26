<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('profile_id')->after('id');  // Or place as needed; assumes auto-increment id exists
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');  // Optional: Add FK constraint
        });
    }

    public function down()
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['profile_id']);  // Drop FK if added
            $table->dropColumn('profile_id');
        });
    }
};