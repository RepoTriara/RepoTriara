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
        Schema::table('tbl_members', function (Blueprint $table) {
            $table->foreign(['client_id'], 'tbl_members_ibfk_1')->references(['id'])->on('tbl_users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['group_id'], 'tbl_members_ibfk_2')->references(['id'])->on('tbl_groups')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_members', function (Blueprint $table) {
            $table->dropForeign('tbl_members_ibfk_1');
            $table->dropForeign('tbl_members_ibfk_2');
        });
    }
};
