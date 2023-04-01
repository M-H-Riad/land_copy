<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIfterBillEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ifter_bill_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->string('pfno')->nullable();
            $table->text('employee_data');
            $table->unsignedInteger('office_id');
            $table->unsignedInteger('designation_id');
            $table->unsignedInteger('designation_ranking')->default(0);
            $table->integer('days')->default(0);
            $table->float('per_day')->default(0);
            $table->float('allowance')->default(0);
            $table->float('ifter_bill')->default(0);
            $table->unsignedInteger('ifter_bill_id');
            $table->foreign('ifter_bill_id')->references('id')->on('ifter_bill');
            $table->unsignedInteger('ifter_bill_departments_id');
            $table->foreign('ifter_bill_departments_id')->references('id')->on('ifter_bill_departments');
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
        Schema::dropIfExists('ifter_bill_employees');
    }
}
