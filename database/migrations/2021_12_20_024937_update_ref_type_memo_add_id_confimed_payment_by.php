<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateRefTypeMemoAddIdConfimedPaymentBy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ref_type_memo', function (Blueprint $table) {
            $table->unsignedBigInteger('id_confirmed_payment_by')->nullable();
            $table->foreign('id_confirmed_payment_by')->references('id')->on('m_employees')->onDelete('cascade')->onUpdate('cascade');
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
            $table->removeColumn('id_confirmed_payment_by');
        });
    }
}
