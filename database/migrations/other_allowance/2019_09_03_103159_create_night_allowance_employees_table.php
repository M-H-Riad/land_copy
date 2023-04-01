<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNightAllowanceEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('night_allowance_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->string('pfno')->nullable();
            $table->text('employee_data');
            $table->unsignedInteger('office_id');
            $table->unsignedInteger('designation_id');
            $table->unsignedInteger('designation_ranking')->default(0);
            $table->float('basic_pay')->default(0);
            $table->float('nights')->default(0);
            $table->float('allowance')->default(0);
            $table->float('night_allowance')->default(0);
            $table->unsignedInteger('night_allowance_id');
            $table->foreign('night_allowance_id')->references('id')->on('night_allowance');
            $table->unsignedInteger('night_allowance_departments_id');
            $table->foreign('night_allowance_departments_id')->references('id')->on('night_allowance_departments');
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
        Schema::dropIfExists('night_allowance_employees');
    }
}
