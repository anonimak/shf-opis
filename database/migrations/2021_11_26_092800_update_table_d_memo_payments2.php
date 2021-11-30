<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableDMemoPayments2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_memo_payments', function (Blueprint $table) {
            //
            $table->string('bank_name', 50)->nullable()->default(null)->change();
            $table->string('bank_account', 20)->nullable()->default(null)->change();
            $table->decimal('amount', 19, 4)->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('d_memo_payments', function (Blueprint $table) {
            //
            $table->dropColumn('bank_name')->change();
            $table->dropColumn('bank_account')->change();
            $table->dropColumn('amount')->change();
        });
    }
}
