<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanApprovesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_approves', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("loan_application_id");
            $table->string("approver_type")->comment("Guarantor,Witness, MD, DMD, Admin");
            $table->unsignedInteger("approver_id")->nullable();
            $table->string("status")->default("Pending")->comment("Pending, Rejected, Approved");
            $table->text("remarks")->nullable();
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
        Schema::dropIfExists('loan_approves');
    }
}
