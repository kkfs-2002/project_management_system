<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            // FK links back to profiles
            $table->unsignedBigInteger('developer_id');
            $table->unsignedBigInteger('project_manager_id');

            // Read‑friendly copies (prevents extra joins in simple views)
            $table->string('developer_name');
            $table->string('project_manager_name');

            $table->string('title');
            $table->text('description');
            $table->date('deadline');

            $table->enum('status', ['Assigned', 'Forwarded', 'Completed'])
                  ->default('Assigned');

            $table->timestamp('pm_forwarded_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();

            // integrity
            $table->foreign('developer_id')->references('id')->on('profiles')->cascadeOnDelete();
            $table->foreign('project_manager_id')->references('id')->on('profiles')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
