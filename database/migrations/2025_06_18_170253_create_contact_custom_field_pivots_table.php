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
        Schema::create('contact_custom_field_pivots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('contact_id')->constrained('contacts', 'id');
            $table->foreignId('custom_field_id')->constrained('custom_fields', 'id');
            $table->string('field_value');
            $table->boolean('is_merge')->default(false);
            $table->foreignId('merged_id')->nullable()->constrained('contacts', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_custom_field_pivots');
    }
};
