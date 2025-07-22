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
    Schema::create('assigned_tasks', function (Blueprint $table) {
        $table->id();

        // Foreign keys
        $table->unsignedBigInteger('project_id');
        $table->unsignedBigInteger('developer_id');
        $table->unsignedBigInteger('project_manager_id');

        // Names for easy display
        $table->string('developer_name');
        $table->string('project_manager_name');

        // Task details
        $table->string('title');
        $table->text('description');

        // Dates
        $table->date('start_date');
        $table->date('deadline');

        // Status
        $table->enum('status', ['Pending', 'Forwarded', 'Completed'])->default('Pending');

        // Optional timestamps for actions
        $table->timestamp('pm_forwarded_at')->nullable();
        $table->timestamp('completed_at')->nullable();

        $table->timestamps();

        // Foreign key constraints
        $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        $table->foreign('developer_id')->references('id')->on('profiles')->onDelete('cascade');
        $table->foreign('project_manager_id')->references('id')->on('profiles')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assigned_tasks');
    }
};
