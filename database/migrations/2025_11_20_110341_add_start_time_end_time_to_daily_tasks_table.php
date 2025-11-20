<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartTimeEndTimeToDailyTasksTable extends Migration
{
    public function up()
    {
        Schema::table('daily_tasks', function (Blueprint $table) {
            $table->time('start_time')->default('09:00:00');
            $table->time('end_time')->default('17:00:00');
        });
    }

    public function down()
    {
        Schema::table('daily_tasks', function (Blueprint $table) {
            $table->dropColumn(['start_time', 'end_time']);
        });
    }
}