<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefTemplateCost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_template_costs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ref_type_memo');
            $table->string('col_name', 50);
            $table->integer('width');
            $table->timestamps();

            // foreign key
            $table->foreign('id_ref_type_memo')->references('id')->on('ref_type_memo')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_template_costs');
    }
}
