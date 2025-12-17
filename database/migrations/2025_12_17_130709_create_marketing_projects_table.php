<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('marketing_projects', function (Blueprint $table) {
            $table->id();
            
            // Client Information
            $table->string('client_name');
            $table->string('phone_number', 20);
            $table->date('date');
            
            // Project Details
            $table->string('project_type');
            $table->string('project_category');
            $table->decimal('project_price', 15, 2);
            
            // Communication
            $table->string('contact_method');
            $table->string('call_sequence'); // 1st, 2nd, 3rd
            $table->date('first_call_date')->nullable();
            $table->date('second_call_date')->nullable();
            $table->date('third_call_date')->nullable();
            $table->text('comments');
            
            // Assignment
            $table->string('marketing_manager_id');
            $table->foreign('marketing_manager_id')->references('employee_id')->on('profiles')->onDelete('cascade');
            
            // Status
            $table->string('status')->default('pending');
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('marketing_projects');
    }
};