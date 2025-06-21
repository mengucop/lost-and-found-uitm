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
    Schema::create('items', function (Blueprint $table) {
    $table->id(); // <-- Add this line as the first column

    $table->string('from');
    $table->string('description')->nullable();
    $table->string('pic')->nullable();
    $table->string('type');
    $table->string('status')->default('Unresolved');
    $table->json('image_labels')->nullable();
    $table->string('selected_label')->nullable();
    $table->timestamp('created_at')->nullable();
    $table->timestamp('updated_at')->nullable();
    $table->double('latitude')->nullable();
    $table->double('longitude')->nullable();
    $table->string('reason')->nullable();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
