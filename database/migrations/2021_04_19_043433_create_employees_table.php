<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_branch');
            $table->unsignedBigInteger('id_title');
            $table->string('firstname', 30);
            $table->string('lastname', 30);
            $table->enum('gender', ['L', 'P']);
            $table->string('nik', 10);
            $table->string('address', 180)->nullable();
            $table->string('address_two', 180)->nullable();
            $table->string('email', 50);
            $table->string('mobile', 25)->nullable();
            $table->string('phone', 25)->nullable();
            $table->string('phone_two', 25)->nullable();
            $table->date('hired_at')->nullable();
            $table->date('terminated_at')->nullable();
            $table->softDeletes();
            $table->timestamps();

            // foreign key
            $table->foreign('id_branch')->references('id')->on('m_branches')->nullOnDelete();
            $table->foreign('id_title')->references('id')->on('ref_titles')->nullOnDelete();
        });

        Schema::create('emp_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_employee');
            $table->unsignedBigInteger('id_position');
            $table->unsignedBigInteger('id_branch');
            $table->boolean('is_manager')->default(false);
            $table->date('year_started');
            $table->date('year_finished');
            $table->softDeletes();
            $table->timestamps();

            // foreign key
            $table->foreign('id_employee')->references('id')->on('m_employees');
            $table->foreign('id_position')->references('id')->on('ref_positions');
            $table->foreign('id_branch')->references('id')->on('m_branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_employees');
        Schema::dropIfExists('emp_history');
    }
}
