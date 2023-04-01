<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArrDedOffAlertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arr_ded_off_alert', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->integer('employee_id');
            $table->integer('pfno')->nullable();
            $table->integer('month');
            $table->integer('year');
            $table->text('heads')->nullable();
            $table->boolean('is_send')->default(0);
            $table->boolean('is_viewed')->default(0);
            $table->date('sending_date')->nullable();
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
        Schema::dropIfExists('arr_ded_off_alert');
    }
}
