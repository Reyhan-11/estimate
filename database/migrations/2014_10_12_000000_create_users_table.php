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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('image')->nullable();
            $table->timestamp('last_activity')->nullable();
            $table->unsignedBigInteger('divisi_id')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();

            if (Schema::hasTable('divisis')) {
                $table->foreignId('divisi_id')->references('id')->on('divisis')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
