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
    Schema::table('students', function (Blueprint $table) {
        // Drop the current primary key on email first
        $table->dropPrimary();

        // Now add the id column as primary auto-increment
        $table->id()->first();
    });
    }

public function down()
{
    Schema::table('students', function (Blueprint $table) {
        $table->dropPrimary(['id']);
        $table->dropColumn('id');
        $table->primary('email');
    });
}
};
