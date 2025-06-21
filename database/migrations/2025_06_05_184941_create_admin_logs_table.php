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
        Schema::create('admin_logs', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('admin_id');
    $table->unsignedBigInteger('item_id');
    $table->string('action'); // approve, flag, delete
    $table->timestamps();

    $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
    $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_logs');
    }
};
