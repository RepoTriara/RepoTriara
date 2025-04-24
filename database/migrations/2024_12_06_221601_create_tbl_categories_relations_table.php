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
        Schema::create('tbl_categories_relations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->timestamp('timestamp')->useCurrent();
            $table->integer('file_id')->index('file_id');
            $table->integer('cat_id')->index('cat_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_categories_relations');
    }
};
