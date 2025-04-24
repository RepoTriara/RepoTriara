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
        Schema::create('tbl_files_relations', function (Blueprint $table) {
            $table->integer('id', true);
            $table->timestamp('timestamp')->useCurrent();
            $table->integer('file_id')->index('file_id');
            $table->integer('client_id')->nullable()->index('client_id');
            $table->integer('group_id')->nullable()->index('group_id');
            $table->integer('folder_id')->nullable()->index('folder_id');
            $table->integer('hidden');
            $table->integer('download_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_files_relations');
    }
};
