<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableRefTypeMemoAddFieldType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ref_type_memo', function (Blueprint $table) {
            //
            $table->enum('type', ['approval', 'payment'])->default('approval');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ref_type_memo', function (Blueprint $table) {
            //
            $table->removeColumn('type');
        });
    }
}
