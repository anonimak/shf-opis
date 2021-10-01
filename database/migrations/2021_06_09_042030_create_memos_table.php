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
            $table->enum('status', ['submit', 'edit', 'reject', 'revisi', 'approve'])->default('edit');
            $table->char('doc_no', 18)->nullable();
            $table->text('background')->nullable();
            $table->text('information')->nullable();
            $table->text('conclusion')->nullable();
            $table->text('cost')->nullable();
            $table->text('payment')->nullable();
            $table->dateTime('propose_at')->nullable();
            $table->timestamps();

            // foreign key
            $table->foreign('id_type')->references('id')->on('ref_type_memo');
            $table->foreign('id_employee')->references('id')->on('m_employees')->onDelete('cascade')->onUpdate('cascade');
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
    }
}
