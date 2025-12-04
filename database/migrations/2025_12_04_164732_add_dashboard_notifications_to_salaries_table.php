<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('salaries', function (Blueprint $table) {
        $table->boolean('seen_by_employee')->default(false);
        $table->timestamp('seen_at')->nullable();
        $table->string('notification_status')->default('pending')->comment('pending, delivered, seen');
        $table->text('notification_message')->nullable();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('salaries', function (Blueprint $table) {
            //
        });
    }
};
