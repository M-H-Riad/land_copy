<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayrollHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_history', function (Blueprint $table) {
            $table->increments('id');
            $table->text('old_data')->nullable();
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->string('pfno')->nullable();
            $table->integer('designation_id');
            $table->integer('designation_ranking')->nullable();
            $table->integer('designation_status')->nullable();
            $table->integer('scale_id');
            $table->integer('grade');
            $table->integer('office_id');
            $table->integer('employee_job_id')->unsigned();
            $table->double('last_basic_pay')->nullable();
            $table->double('new_basic_pay');
            $table->string('type');
            $table->string('status')->default('Pending');
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
            $table->unsignedInteger('deleted_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_history');
    }
}
