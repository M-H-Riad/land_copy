<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdatePensionApplicationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('pension_application_part_1_ka', function (Blueprint $table) {
          $table->text('p6_job_days_cal_error_exp')->nullable();
          $table->text('p6_job_salary_error_exp')->nullable();
          $table->string('p6_leave_issue_no')->nullable();
          $table->date('p6_leave_issue_date')->nullable();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
