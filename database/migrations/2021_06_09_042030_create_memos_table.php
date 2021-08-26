<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_memos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_type');
            $table->unsignedBigInteger('id_employee');
            $table->string('title', 255);
            $table->enum('status', ['submit', 'edit', 'reject', 'approve'])->default('edit');
            $table->char('doc_no', 18);
            $table->text('background')->nullable();
            $table->text('information')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('payment')->nullable();
            $table->date('propose_at')->nullable();
            $table->timestamps();

            // foreign key
            $table->foreign('id_type')->references('id')->on('ref_type_memo');
            $table->foreign('id_employee')->references('id')->on('m_employees')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('d_memo_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_memo');
            $table->text('real_name');
            $table->text('name');
            $table->timestamps();

            // foreign key
            $table->foreign('id_memo')->references('id')->on('m_memos')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('d_memo_approvers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_memo');
            $table->unsignedBigInteger('id_employee');
            $table->integer('idx');
            $table->enum('status', ['submit', 'edit', 'reject', 'approve', 'revisi'])->default('edit');
            $table->timestamps();

            // foreign key
            $table->foreign('id_memo')->references('id')->on('m_memos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_employee')->references('id')->on('m_employee')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('d_memo_acknowledge', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_memo');
            $table->unsignedBigInteger('id_employee');
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
        Schema::dropIfExists('memos');
        Schema::dropIfExists('d_memo_attachments');
        Schema::dropIfExists('d_memo_approvers');
        Schema::dropIfExists('d_memo_acknowledge');
    }
}
