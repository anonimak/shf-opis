<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEmpHistoryChangeTypeYearStartedFinished extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('emp_history', function (Blueprint $table) {
            //
            $table->dateTime('year_started')->change();
            $table->dateTime('year_finished')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('emp_history', function (Blueprint $table) {
            //
            $table->date('year_started')->change();
            $table->date('year_finished')->change();
        });
    }
}
