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
        Schema::create('tbl_files', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('url');
            $table->text('original_url');
            $table->text('filename');
            $table->text('description');
            $table->timestamp('timestamp')->useCurrent();
            $table->string('uploader', 60);
            $table->integer('expires')->default(0);
            $table->timestamp('expiry_date')->default('2020-01-01 00:00:00');
            $table->integer('public_allow')->default(0);
            $table->string('public_token', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_files');
    }
};
