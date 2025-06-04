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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->char('phone', 12)->nullable();
            $table->boolean('gender')->default(0)->comment('0 => male, 1 => Female');
            $table->string('profile_image')->nullable();
            $table->string('additional_file')->nullable();
            $table->boolean('is_merged')->default(false);
            $table->unsignedBigInteger('merged_into_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};