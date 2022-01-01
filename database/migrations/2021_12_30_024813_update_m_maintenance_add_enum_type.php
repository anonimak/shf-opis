<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMMaintenanceAddEnumType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_maintenance', function (Blueprint $table) {
            $table->enum('type', ['primary', 'secondary', 'info', 'success', 'warning', 'danger'])->default('primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('m_maintenance', function (Blueprint $table) {
            $table->removeColumn('type');
        });
    }
}
