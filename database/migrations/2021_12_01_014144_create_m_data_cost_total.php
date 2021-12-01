<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMDataCostTotal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_data_cost_total', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_memo');
            $table->decimal('sub_total', 19, 2)->default(0);
            $table->decimal('pph', 19, 2)->nullable()->default(0);
            $table->decimal('ppn', 19, 2)->default(0);
            $table->decimal('grand_total', 19, 2)->default(0);
            $table->timestamps();

            //foreignkey
            $table->foreign('id_memo')->references('id')->on('m_memos')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('m_data_cost_total');
    }
}
