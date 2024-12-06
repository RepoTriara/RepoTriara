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
        Schema::table('tbl_files_relations', function (Blueprint $table) {
            $table->foreign(['file_id'], 'tbl_files_relations_ibfk_1')->references(['id'])->on('tbl_files')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['client_id'], 'tbl_files_relations_ibfk_2')->references(['id'])->on('tbl_users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['group_id'], 'tbl_files_relations_ibfk_3')->references(['id'])->on('tbl_groups')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['folder_id'], 'tbl_files_relations_ibfk_4')->references(['id'])->on('tbl_folders')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_files_relations', function (Blueprint $table) {
            $table->dropForeign('tbl_files_relations_ibfk_1');
            $table->dropForeign('tbl_files_relations_ibfk_2');
            $table->dropForeign('tbl_files_relations_ibfk_3');
            $table->dropForeign('tbl_files_relations_ibfk_4');
        });
    }
};
