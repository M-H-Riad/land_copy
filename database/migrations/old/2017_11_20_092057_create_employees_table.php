<?php

use Database\Migration\AuditTrail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');

            $table->string('employee_id',30);
            $table->string('first_name',30)->nullable();
            $table->string('middle_name',30)->nullable();
            $table->string('last_name',30)->nullable();
            $table->string('father_name',100)->nullable();
            $table->string('mother_name',100)->nullable();
            $table->string('religion',15)->nullable();
            $table->string('gender',10)->nullable();
            $table->string('blood_group',3)->nullable();
            $table->string('marital_status',15)->nullable();

            $table->date('date_of_birth')->nullable();
            $table->string('nid',20)->nullable();
            $table->string('tin',20)->nullable();

            $table->string('place_of_birth',100)->nullable();
            $table->string('spouse_name',100)->nullable();
            $table->string('spouse_qualification')->nullable();
            $table->string('spouse_profession')->nullable();

            $table->string('personnel_file_no')->nullable();
            $table->string('passport_no')->nullable();

            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('bank_account_no')->nullable();
            $table->string('provident_fund_no')->nullable();

            $table->string('mobile',20)->nullable();
            $table->string('email')->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
