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
    Schema::table('claims', function (Blueprint $table) {
        $table->unsignedBigInteger('item_id')->after('id');

        // Optional: Add foreign key constraint if needed
        $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
    });
}

public function down()
{
    Schema::table('claims', function (Blueprint $table) {
        $table->dropForeign(['item_id']);
        $table->dropColumn('item_id');
    });
}

};
