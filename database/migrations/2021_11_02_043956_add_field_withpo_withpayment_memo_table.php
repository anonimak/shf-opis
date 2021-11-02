<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldWithpoWithpaymentMemoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_memos', function (Blueprint $table) {
            $table->boolean('with_po');
            $table->boolean('with_payment');
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
            $table->dropColumn('with_po');
            $table->dropColumn('with_payment');
        });
    }
}
