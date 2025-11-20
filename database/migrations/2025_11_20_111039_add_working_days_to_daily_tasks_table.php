<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWorkingDaysToDailyTasksTable extends Migration
{
    public function up()
    {
        Schema::table('daily_tasks', function (Blueprint $table) {
            $table->text('working_days')->nullable()->after('end_time');
        });
    }

    public function down()
    {
        Schema::table('daily_tasks', function (Blueprint $table) {
            $table->dropColumn('working_days');
        });
    }
}