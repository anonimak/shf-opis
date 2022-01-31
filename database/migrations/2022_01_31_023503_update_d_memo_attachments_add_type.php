<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateDMemoAttachmentsAddType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_memo_attachments', function (Blueprint $table) {
            $table->enum('type', ['memo', 'payment'])->default('memo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('d_memo_attachments', function (Blueprint $table) {
            $table->removeColumn('type');
        });
    }
}
