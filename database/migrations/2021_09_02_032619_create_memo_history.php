<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemoHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_memo_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_memo');
            $table->text('title');
            $table->enum('type', ['info', 'success', 'danger', 'warning']);
            $table->text('content')->nullable();
            $table->timestamps();

            // foreign key
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
        Schema::dropIfExists('d_memo_history');
    }
}
