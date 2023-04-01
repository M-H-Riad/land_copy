<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeQuartersTable extends Migration
{


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_quarters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->foreign('employee_id')->references('id')->on('employees');

            $table->string('allotment_reference');
            $table->date('reference_date');
            $table->date('posting_date');
            $table->string('location');
            $table->string('road')->nullable();
            $table->string('building')->nullable();
            $table->string('flat')->nullable();
            $table->string('flat_type')->nullable();
            $table->string('size_sft')->nullable();
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
        Schema::dropIfExists('employee_quarters');
    }
}
