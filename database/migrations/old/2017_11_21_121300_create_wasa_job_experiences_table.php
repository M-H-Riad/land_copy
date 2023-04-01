<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWasaJobExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_wasa_job_experiences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees');

            $table->string('office_order_no',30)->nullable();
            $table->date('order_date')->nullable();
            $table->date('joining_date')->nullable();
            $table->integer('designation_id')->nullable();
            $table->integer('scale_id')->nullable();
            $table->integer('office_id')->nullable();
            $table->double('basic_pay')->nullable();
            $table->timestamps();

            $table->softDeletes();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wasa_job_experiences');
    }
}
