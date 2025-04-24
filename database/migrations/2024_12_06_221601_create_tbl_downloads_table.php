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
        Schema::create('tbl_downloads', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id')->nullable()->index('user_id');
            $table->integer('file_id')->index('file_id');
            $table->timestamp('timestamp')->useCurrent();
            $table->string('remote_ip', 45)->nullable();
            $table->text('remote_host')->nullable();
            $table->boolean('anonymous')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_downloads');
    }
};
