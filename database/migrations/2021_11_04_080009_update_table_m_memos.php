<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableMMemos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_memos', function (Blueprint $table) {
            $table->enum('status_po', ['submit', 'edit', 'approve'])->default('edit');
            $table->enum('status_payment', ['submit', 'edit', 'approve'])->default('edit');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_memos', function (Blueprint $table) {
            $table->dropColumn('status_po');
            $table->dropColumn('status_payment');
        });
    }
}
