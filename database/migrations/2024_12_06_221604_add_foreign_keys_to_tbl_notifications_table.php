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
        Schema::table('tbl_notifications', function (Blueprint $table) {
            $table->foreign(['file_id'], 'tbl_notifications_ibfk_1')->references(['id'])->on('tbl_files')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['client_id'], 'tbl_notifications_ibfk_2')->references(['id'])->on('tbl_users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_notifications', function (Blueprint $table) {
            $table->dropForeign('tbl_notifications_ibfk_1');
            $table->dropForeign('tbl_notifications_ibfk_2');
        });
    }
};
