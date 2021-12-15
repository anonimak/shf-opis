<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableMMemoChangeStatusPOAndPayment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('m_memos', function (Blueprint $table) {
            \DB::statement("ALTER TABLE `m_memos` CHANGE `status_po` `status_po` ENUM('submit', 'edit', 'approve','reject') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'edit';");
            \DB::statement("ALTER TABLE `m_memos` CHANGE `status_payment` `status_payment` ENUM('submit', 'edit', 'approve','reject') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'edit';");
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
            $table->enum('status_po', ['submit', 'edit', 'approve'])->default('edit')->change();
            $table->enum('status_payment', ['submit', 'edit', 'approve'])->default('edit')->change();
        });
    }
}
