<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDInvoiceTableAddEnumPph extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_memo_invoices', function (Blueprint $table) {
            $table->enum('pph', ['none', "pph21", "pph23", "pph4_2_kon", "pph4_2_kon_klas", "pph4_2_rent"])->default('none');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('d_memo_invoices', function (Blueprint $table) {
            $table->removeColumn('pph');
        });
    }
}
