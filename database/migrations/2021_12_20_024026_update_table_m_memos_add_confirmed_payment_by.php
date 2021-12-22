<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableMMemosAddConfirmedPaymentBy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_memos', function (Blueprint $table) {
            //add id employee
            $table->unsignedBigInteger('confirmed_payment_by')->nullable();
            $table->foreign('confirmed_payment_by')->references('id')->on('m_employees')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_memos', function (Blueprint $table) {
            $table->removeColumn('confirmed_payment_by');
        });
    }
}
