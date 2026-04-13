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
        Schema::create('employee_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('institution_name');
            $table->string('course_study');
            $table->string('qualification_type');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
});

        Schema::create('employee_families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('full_name');
            $table->string('relationship');
            $table->string('phone_number');
            $table->boolean('is_next_of_kin')->default(false);
            $table->boolean('is_emergency_contact')->default(false);
            $table->timestamps();
});

        Schema::create('employee_guarantors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('guarantor_name');
            $table->string('phone_number');
            $table->boolean('is_internal_staff')->default(false);
            $table->foreignId('internal_staff_id')->nullable()->constrained('employees');
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_profiles');
    }
};
