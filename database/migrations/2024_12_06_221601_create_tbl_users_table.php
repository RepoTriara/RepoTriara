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
        Schema::create('tbl_users', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('user', 60);
            $table->string('password', 60);
            $table->text('name');
            $table->string('email', 60);
            $table->boolean('level')->default(false);
            $table->timestamp('timestamp')->useCurrent();
            $table->text('address')->nullable();
            $table->string('phone', 32)->nullable();
            $table->boolean('notify')->default(false);
            $table->text('contact')->nullable();
            $table->string('created_by', 60)->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('account_requested')->default(false);
            $table->boolean('account_denied')->default(false);
            $table->integer('max_file_size')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_users');
    }
};
