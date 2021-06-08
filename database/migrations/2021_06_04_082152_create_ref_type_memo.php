<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefTypeMemo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_type_memo', function (Blueprint $table) {
            $table->id();
            $table->integer('id_ref_module_approver');
            $table->integer('id_department')->nullable();
            $table->string('name', 50);
            $table->softDeletes();
            $table->timestamps();

            // foriegn
            $table->foreign('id_ref_module_approver')->references('id')->on('ref_module_approver');
            $table->foreign('id_department')->references('id')->on('m_departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_type_memo');
    }
}
