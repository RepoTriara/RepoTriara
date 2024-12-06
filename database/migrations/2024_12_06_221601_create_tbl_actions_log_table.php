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
        Schema::create('tbl_actions_log', function (Blueprint $table) {
            $table->integer('id', true);
            $table->timestamp('timestamp')->useCurrent();
            $table->integer('action');
            $table->integer('owner_id');
            $table->text('owner_user')->nullable();
            $table->integer('affected_file')->nullable();
            $table->integer('affected_account')->nullable();
            $table->text('affected_file_name')->nullable();
            $table->text('affected_account_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_actions_log');
    }
};
