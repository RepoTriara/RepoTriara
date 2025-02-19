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
        Schema::create('tbl_categories', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('name', 32);
            $table->integer('parent')->nullable()->index('parent');
            $table->text('description')->nullable();
            $table->string('created_by', 60)->nullable();
            $table->timestamp('timestamp')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_categories');
    }
};
