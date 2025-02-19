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
        Schema::create('tbl_notifications', function (Blueprint $table) {
            $table->integer('id', true);
            $table->timestamp('timestamp')->useCurrent();
            $table->integer('file_id')->index('file_id');
            $table->integer('client_id')->index('client_id');
            $table->integer('upload_type');
            $table->integer('sent_status');
            $table->integer('times_failed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_notifications');
    }
};
