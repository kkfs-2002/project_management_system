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
        $table->enum('payment_method', ['bank_transfer', 'cash', 'cheque', 'online'])->nullable()->after('status');
        $table->text('notes')->nullable()->after('payment_method');
    });
}

public function down()
{
    Schema::table('salaries', function (Blueprint $table) {
        $table->dropColumn(['payment_method', 'notes']);
    });
}
};
