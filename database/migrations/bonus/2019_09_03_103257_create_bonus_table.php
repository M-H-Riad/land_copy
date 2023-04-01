<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBonusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bonus_type',20);
            $table->string('title',100);
            $table->string('bonus_for',20);
            $table->integer('percentage');
            $table->integer('month');
            $table->integer('year');
            $table->integer('payroll_month_id')->nullable();
            $table->integer('generate_count')->default(0);
            $table->boolean('waiting_job')->default(0);
            $table->boolean('is_generated')->default(0);
            $table->boolean('is_locked')->default(0);
            $table->string('queue_status',20)->nullable();
            $table->timestamp('queued_at')->nullable();
            $table->timestamp('queue_start')->nullable();
            $table->timestamp('queue_done')->nullable();
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
        Schema::dropIfExists('bonus');
    }
}
