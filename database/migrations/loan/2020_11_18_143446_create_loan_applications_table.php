<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("employee_id");
            $table->string("pfno")->nullable();
            $table->unsignedInteger("loan_category_id");
            $table->integer('loan_amount')->nullable();
            $table->integer('max_loan_amount')->nullable();
            $table->date("loan_eff_date")->nullable();
            $table->string("status")->default("Pending")->comment("Pending, Approved, Reject");
            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();
            $table->unsignedInteger("deleted_by")->nullable();
            $table->softDeletes("deleted_at");
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
        Schema::dropIfExists('loan_applications');
    }
}
