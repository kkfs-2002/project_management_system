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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_number')->nullable();
            $table->string('project_name')->nullable();
            $table->enum('project_type', ['Website', 'System','Mobile App','Other'])->nullable();
            $table->string('technology')->nullable();
            $table->date('reminder_date')->nullable();
            $table->text('note')->nullable();
    
            // ✅ Remove 'after(...)' from here:
            $table->decimal('amount', 10, 2)->nullable();
            $table->enum('payment_status', ['No Payment', 'Advance', 'Full'])->default('No Payment');
            $table->string('status')->default('inactive');
            $table->enum('edit_permission', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('marketing_manager_id')->nullable();
    
            $table->timestamps();
        });
    }
    
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
