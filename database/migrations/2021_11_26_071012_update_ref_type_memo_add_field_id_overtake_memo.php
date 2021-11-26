<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRefTypeMemoAddFieldIdOvertakeMemo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ref_type_memo', function (Blueprint $table) {
            $table->unsignedBigInteger('id_overtake_memo')->nullable();
            $table->foreign('id_overtake_memo')->references('id')->on('m_employees')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ref_type_memo', function (Blueprint $table) {
            $table->removeColumn('id_overtake_memo');
        });
    }
}
