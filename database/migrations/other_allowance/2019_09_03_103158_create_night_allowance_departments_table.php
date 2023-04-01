<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNightAllowanceDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('night_allowance_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',100);
            $table->unsignedInteger('night_allowance_id');
            $table->foreign('night_allowance_id')->references('id')->on('night_allowance');
            $table->unsignedInteger('department_id');
            $table->foreign('department_id')->references('id')->on('departments');
            $table->string('memo_no')->default('46.113.317.00.00.'.date('Y').'/');
            $table->string('bank_account_number')->default('CD-200040491');
            $table->string('file')->nullable();
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
        Schema::dropIfExists('night_allowance_departments');
    }
}
