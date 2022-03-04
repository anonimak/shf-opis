<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMMemosAddFieldIsCostInvoice extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_memos', function (Blueprint $table) {
            $table->boolean('is_cost_invoice')->default(false);
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
            $table->removeColumn('is_cost_invoice');
        });
    }
}
