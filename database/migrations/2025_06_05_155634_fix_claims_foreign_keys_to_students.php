<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('claims', function (Blueprint $table) {
            // Remove existing constraints
            $table->dropForeign(['claimed_by']);
            $table->dropForeign(['claimed_to']);

            // Convert columns to match students.id type if needed
            $table->unsignedBigInteger('claimed_by')->change();
            $table->unsignedBigInteger('claimed_to')->change();

            // Add correct constraints
            $table->foreign('claimed_by')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');

            $table->foreign('claimed_to')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->dropForeign(['claimed_by']);
            $table->dropForeign(['claimed_to']);

            // Optionally revert to users if needed
            $table->foreign('claimed_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('claimed_to')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }
};
