<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_memo_invoices', function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->id();
            $table->unsignedBigInteger('id_memo');
            $table->string('no_invoice', 50)->nullable()->default(null);
            $table->boolean('ppn');
            $table->boolean('npwp');
            $table->boolean('grossup');
            $table->decimal('ppn_value', 19, 2)->default(0);
            $table->decimal('grossup_value', 19, 2)->default(0);
            $table->decimal('pph_value', 19, 2)->default(0);
            $table->decimal('total', 19, 2)->default(0);
            $table->text('others');
            $table->timestamps();

            //foreign key
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
        Schema::dropIfExists('d_invoices');
    }
}
