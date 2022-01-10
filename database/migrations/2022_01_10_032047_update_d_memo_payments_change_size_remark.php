<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDMemoPaymentsChangeSizeRemark extends Migration
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
            \DB::statement('ALTER TABLE d_memo_payments MODIFY COLUMN remark VARCHAR(255)');
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
        });
    }
}
