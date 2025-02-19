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
        Schema::create('tbl_groups', function (Blueprint $table) {
            $table->integer('id', true);
            $table->timestamp('timestamp')->useCurrent();
            $table->string('created_by', 32);
            $table->string('name', 250)->nullable();
            $table->text('description');
            $table->boolean('public')->default(false);
            $table->string('public_token', 32)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_groups');
    }
};
