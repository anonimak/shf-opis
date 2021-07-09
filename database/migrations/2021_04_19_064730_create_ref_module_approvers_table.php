<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefModuleApproversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_module_approvers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('d_module_approvers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ref_module_approver');
            $table->unsignedBigInteger('id_ref_position');
            $table->integer('idx');
            $table->timestamps();

            // foreign key
            $table->foreign('id_ref_module_approver')->references('id')->on('ref_module_approvers')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_ref_position')->references('id')->on('ref_positions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_module_approvers');
        Schema::dropIfExists('d_module_approvers');
    }
}
