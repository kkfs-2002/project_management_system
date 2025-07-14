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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();

            // Foreign key linking to profiles table, not employees
            $table->foreignId('profile_id')->constrained('profiles')->onDelete('cascade');

            $table->decimal('amount', 10, 2);
            $table->date('salary_month'); // Store the salary month, e.g. '2025-07-01'
            $table->string('status')->default('Paid');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
