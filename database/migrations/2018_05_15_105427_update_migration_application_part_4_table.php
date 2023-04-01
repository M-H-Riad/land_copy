<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateMigrationApplicationPart4Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('pension_application_part_1_ka', function (Blueprint $table) {

          $table->decimal('p4_total_pension', 10, 4)->default(0.0)->nullable();
          $table->decimal('p4_last_basic_after_incr', 10, 4)->default(0.0)->nullable();
          $table->decimal('p4_percent1', 10, 4)->default(0.0)->nullable();
          $table->decimal('p4_pension_amount', 10, 4)->default(0.0)->nullable();

          $table->decimal('p4_percent_neet_obosor_pension', 10, 4)->default(0.0)->nullable();
          $table->decimal('p4_amount_neet_obosor_pension', 10, 4)->default(0.0)->nullable();

          $table->decimal('p4_one_time_payment', 10, 4)->default(0.0)->nullable();
          $table->decimal('p4_net_pension_amount', 10, 4)->default(0.0)->nullable();

          $table->text('p4_leave_encashment_remarks')->nullable();
          $table->integer('p4_leave_encashment_days')->nullable()->default(0);
          $table->integer('p4_leave_encashment_months')->nullable()->default(0);
          $table->integer('p4_leave_encashment_years')->nullable()->default(0);

          $table->decimal('p4_leave_encashment_amount', 10, 4)->nullable()->default(0.0);

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
