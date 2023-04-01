<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanCommitteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_committees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("employee_id");
            $table->string("user_type");
            $table->date("joined_at")->nullable();
            $table->date("end_at")->nullable();
            $table->string("status")->default("Active");
            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("deleted_by")->nullable();
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
        Schema::dropIfExists('loan_committees');
    }
}
