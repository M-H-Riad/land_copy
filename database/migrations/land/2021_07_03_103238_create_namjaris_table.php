<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNamjarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('namjaris', function (Blueprint $table) {
            $table->increments('id');
            $table->foreign('land_id')->references('id')->on('lands')->onDelete('cascade');
            $table->integer('status');
            $table->date('namjari_date');
            $table->date('purchase_date');
            $table->integer('namjari_khotian_no');
            $table->integer('namjarir_pore_khotian_no');
            $table->integer('namjarir_dag_no');
            $table->string('oi_dage_mot_jomi');
            $table->integer('namjari_jot_no');
            $table->integer('namjari_jl_no');
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
        Schema::dropIfExists('namjaris');
    }
}
