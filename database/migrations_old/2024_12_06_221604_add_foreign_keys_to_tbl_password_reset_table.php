<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tbl_password_reset', function (Blueprint $table) {
            $table->foreign(['user_id'], 'tbl_password_reset_ibfk_1')->references(['id'])->on('tbl_users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_password_reset', function (Blueprint $table) {
            $table->dropForeign('tbl_password_reset_ibfk_1');
        });
    }
};
