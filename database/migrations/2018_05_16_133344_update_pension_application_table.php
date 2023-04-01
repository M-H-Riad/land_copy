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
        //  $table->decimal('p4_net_pension_amount', 10, 4)->default(0.0)->nullable();
          $table->decimal('p4_1st_50_percent', 10, 4)->default(0.0)->nullable();
          $table->decimal('p4_2nd_50_percent', 10, 4)->default(0.0)->nullable();
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
