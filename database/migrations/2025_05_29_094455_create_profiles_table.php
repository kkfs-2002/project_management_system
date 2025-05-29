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
        Schema::create('profiles', function (Blueprint $table) {
      $table->id();
        $table->string('full_name');
        $table->string('employee_id')->unique();
        $table->string('nic');
        $table->date('dob');
        $table->string('gender');
        $table->string('profile_photo')->nullable();
        $table->string('phone');
        $table->string('email')->unique();
        $table->text('address');
        $table->string('emergency_contact_name');
        $table->string('emergency_contact_phone');

        $table->string('department');
        $table->string('job_title');
        $table->string('employment_type');
        $table->date('date_of_joining');
        $table->string('employee_status');
        $table->string('supervisor');
        $table->string('work_location');

        $table->string('username')->unique();
        $table->string('role');
        $table->string('password');

        $table->decimal('basic_salary', 10, 2);
        $table->string('bank_account_number');
        $table->string('bank_name');
        $table->string('epf_etf_number')->nullable();
        $table->string('tax_code')->nullable();

        $table->string('resume')->nullable();
        $table->string('offer_letter')->nullable();
        $table->string('id_copy')->nullable();
        $table->string('signed_contract')->nullable();
        $table->string('certificates')->nullable();

        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
