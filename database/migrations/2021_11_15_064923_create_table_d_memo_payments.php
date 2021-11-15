<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDMemoPayments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_memo_payments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('bank_name', 50);
            $table->string('bank_account', 20);
            $table->decimal('amount', 19, 4);
            $table->string('remark', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_d_memo_payments');
    }
}
