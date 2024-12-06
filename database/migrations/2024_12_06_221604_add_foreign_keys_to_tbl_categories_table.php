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
        Schema::table('tbl_categories', function (Blueprint $table) {
            $table->foreign(['parent'], 'tbl_categories_ibfk_1')->references(['id'])->on('tbl_categories')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_categories', function (Blueprint $table) {
            $table->dropForeign('tbl_categories_ibfk_1');
        });
    }
};
