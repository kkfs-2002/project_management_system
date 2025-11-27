<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('project_accounts', function (Blueprint $table) {
            $table->decimal('profit', 10, 2)->default(0);
            $table->decimal('balance', 10, 2)->default(0);
            $table->date('renewal_date')->nullable();
           
        });
    }

    public function down(): void
    {
        Schema::table('project_accounts', function (Blueprint $table) {
            $table->dropColumn(['profit', 'balance', 'renewal_date']);
        });
    }
};