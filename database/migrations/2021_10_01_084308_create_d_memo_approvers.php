<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDMemoApprovers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('d_memo_approvers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_memo');
            $table->unsignedBigInteger('id_employee');
            $table->integer('idx');
            $table->text('msg')->nullable();
            $table->enum('status', ['submit', 'edit', 'reject', 'approve', 'revisi'])->default('edit');
            $table->timestamps();

            // foreign key
            $table->foreign('id_memo')->references('id')->on('m_memos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_employee')->references('id')->on('m_employee')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_memo_approvers');
    }
}
