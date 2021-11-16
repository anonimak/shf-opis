<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableDPoApprover extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('d_po_approver', function (Blueprint $table) {
            $table->enum('type_approver', ['approver', 'acknowledge'])->default('approver');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('d_po_approver', function (Blueprint $table) {
            $table->dropColumn('type_approver');
        });
    }
}
