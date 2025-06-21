<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->boolean('is_approved')->default(false);  // Approval status
            $table->boolean('is_flagged')->default(false);   // Flag status
            $table->string('flag_reason')->nullable();       // Flag reason (optional)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('is_approved');    // Drop 'is_approved' column
            $table->dropColumn('is_flagged');     // Drop 'is_flagged' column
            $table->dropColumn('flag_reason');    // Drop 'flag_reason' column
        });
    }
};
