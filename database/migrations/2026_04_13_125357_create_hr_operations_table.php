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
    Schema::create('leave_plans', function (Blueprint $table) {
        $table->id();
        $table->string('plan_name');
        $table->integer('total_duration_days');
        $table->boolean('is_recallable')->default(true);
        $table->timestamps();
    });

    Schema::create('leave_requests', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained();
        $table->foreignId('leave_plan_id')->constrained();
        $table->date('start_date');
        $table->date('end_date');
        $table->integer('duration_days');
        $table->foreignId('relief_officer_id')->constrained('employees');
        $table->enum('status', ['Pending', 'Approved', 'Declined', 'Recalled'])->default('Pending');
        $table->string('attachment_path')->nullable();
        $table->timestamps();
    });

    Schema::create('payrolls', function (Blueprint $table) {
        $table->id();
        $table->foreignId('employee_id')->constrained();
        $table->date('pay_period_start');
        $table->date('pay_period_end');
        $table->decimal('basic_salary', 15, 2);
        $table->decimal('net_pay', 15, 2);
        $table->timestamps();
    });

    Schema::create('payroll_breakdowns', function (Blueprint $table) {
        $table->id();
        $table->foreignId('payroll_id')->constrained()->cascadeOnDelete();
        $table->enum('type', ['allowance', 'deduction', 'tax', 'loan_repayment']);
        $table->string('item_name');
        $table->decimal('amount', 15, 2);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hr_operations');
    }
};
