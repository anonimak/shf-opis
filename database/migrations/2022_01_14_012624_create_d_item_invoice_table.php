<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDItemInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_item_invoice', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_invoice');
            $table->string('description',255);
            $table->string('description2',255);
            $table->integer('qty');
            $table->decimal('price', 19, 2);
            $table->enum('type', ['barang','jasa']);
            $table->timestamps();

            //foreign
            $table->foreign('id_invoice')->references('id')->on('d_invoices')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_item_invoice');
    }
}
