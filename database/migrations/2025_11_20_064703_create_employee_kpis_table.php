<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeKpisTable extends Migration
{
    public function up()
    {
        Schema::create('employee_kpis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profile_id')->constrained()->onDelete('cascade');
            $table->string('kpi_name');
            $table->text('description')->nullable();
            $table->string('measurement_unit'); // hours, tasks, lines, etc
            $table->decimal('daily_target', 8, 2);
            $table->decimal('weekly_target', 8, 2);
            $table->decimal('monthly_target', 8, 2);
            $table->decimal('current_achievement', 8, 2)->default(0);
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employee_kpis');
    }
}