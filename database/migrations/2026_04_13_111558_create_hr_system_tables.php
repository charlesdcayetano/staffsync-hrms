<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        // 1. Core Employees Table
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('employee_code')->unique(); 
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();
            
            // Job & Organization Info
            $table->string('department')->nullable();
            $table->string('designation')->nullable();
            $table->string('employment_type')->nullable(); 
            $table->string('job_title')->nullable();
            $table->date('joining_date')->nullable();
            $table->string('status')->default('Active');
            
            // Additional Info
            $table->string('gender')->nullable(); 
            $table->boolean('is_admin')->default(false); 

            $table->timestamps();
        });

        // 2. Family & Next of Kin (Renamed to employee_families for your Seeder)
        // 2. Family & Next of Kin
        Schema::create('employee_families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('name'); 
            $table->string('relation'); // Use 'relationship'
            $table->string('phone'); // Use 'contact_number'
            $table->text('address')->nullable();
            $table->boolean('is_next_of_kin')->default(false);
            $table->boolean('is_emergency_contact')->default(false);
            $table->timestamps();
        });

        // 3. Finance & Payroll Details
        Schema::create('employee_finances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('bank_name');
            $table->string('account_number');
            $table->string('account_name')->nullable();
            $table->decimal('basic_salary', 10, 2)->default(0); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('employee_finances');
        Schema::dropIfExists('employee_families');
        Schema::dropIfExists('employees');
    }
};