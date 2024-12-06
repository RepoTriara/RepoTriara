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
        Schema::create('tbl_folders', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('parent')->nullable()->index('parent');
            $table->string('name', 32);
            $table->timestamp('timestamp')->useCurrent();
            $table->integer('client_id')->nullable()->index('client_id');
            $table->integer('group_id')->nullable()->index('group_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_folders');
    }
};
