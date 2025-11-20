<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDailyTasksTable extends Migration
{
    public function up()
    {
        Schema::create('daily_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->date('task_date');
            $table->string('task_name');
            $table->text('description')->nullable();
            $table->enum('task_type', ['development', 'testing', 'design', 'meeting', 'documentation', 'other']);
            $table->integer('target_count')->default(1); // කොටස් ගණන
            $table->integer('completed_count')->default(0);
            $table->time('estimated_time')->nullable();
            $table->time('actual_time')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent']);
            $table->enum('status', ['pending', 'in_progress', 'completed', 'verified'])->default('pending');
            $table->text('notes')->nullable();
            $table->foreignId('assigned_by')->constrained('profiles');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['profile_id', 'task_date', 'task_name']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('daily_tasks');
    }
}