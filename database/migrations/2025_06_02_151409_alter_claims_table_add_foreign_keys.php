<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('claims', function (Blueprint $table) {
            // Convert VARCHAR to unsignedBigInteger
            $table->unsignedBigInteger('claimed_by')->change();
            $table->unsignedBigInteger('claimed_to')->change();

            // Add foreign key constraints
            $table->foreign('claimed_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('claimed_to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->dropForeign(['claimed_by']);
            $table->dropForeign(['claimed_to']);

            // Revert back to VARCHAR if needed (optional)
            $table->string('claimed_by')->change();
            $table->string('claimed_to')->change();
        });
    }
};
