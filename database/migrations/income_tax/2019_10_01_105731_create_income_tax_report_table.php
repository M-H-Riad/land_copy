<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomeTaxReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('income_tax_report', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100);
            $table->string('cheque_no',100)->nullable();
            $table->date('cheque_date')->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->integer('payroll_month_id');
            $table->float('total_amount');
            $table->integer('bank_id')->nullable();
            $table->integer('bank_branch_id')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->boolean('is_locked')->default(0);
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
        Schema::dropIfExists('income_tax_report');
    }
}
