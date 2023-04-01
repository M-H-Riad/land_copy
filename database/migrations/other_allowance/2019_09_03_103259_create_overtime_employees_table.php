<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOvertimeEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtime_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->string('pfno')->nullable();
            $table->text('employee_data');
            $table->unsignedInteger('office_id');
            $table->unsignedInteger('designation_id');
            $table->unsignedInteger('designation_ranking')->default(0);
            $table->float('basic_pay')->default(0);
            $table->float('hours')->default(0);
            $table->float('allowance')->default(0);
            $table->float('overtime')->default(0);
            $table->string('type',20);
            $table->unsignedInteger('overtime_id');
            $table->foreign('overtime_id')->references('id')->on('overtime');
            $table->unsignedInteger('overtime_departments_id');
            $table->foreign('overtime_departments_id')->references('id')->on('overtime_departments');
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
        Schema::dropIfExists('overtime_employees');
    }
}
