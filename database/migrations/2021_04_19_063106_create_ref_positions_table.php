<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefPositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ref_positions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_departement');
            $table->string('position_name', 50);
            $table->softDeletes();
            $table->timestamps();

            // foreign key
            $table->foreign('id_departement')->references('id')->on('m_departements');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ref_positions');
    }
}
