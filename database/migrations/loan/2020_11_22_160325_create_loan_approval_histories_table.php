<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanApprovalHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_approval_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("loan_application_id");
            $table->unsignedInteger("loan_approve_id")->nullable();
            $table->string("approver_type")->nullable();
            $table->unsignedInteger("approved_by")->nullable();
            $table->text("remarks")->nullable();
            $table->string("loan_status")->nullable();
            $table->integer("status")->default(true);
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
        Schema::dropIfExists('loan_approval_histories');
    }
}
