<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AlterClaimsUseStudentIdsV2 extends Migration
{
    public function up()
    {
        // Drop foreign keys if they exist
        DB::statement("ALTER TABLE claims DROP FOREIGN KEY IF EXISTS claims_claimed_by_foreign;");
        DB::statement("ALTER TABLE claims DROP FOREIGN KEY IF EXISTS claims_claimed_to_foreign;");

        // Drop old claimed_by and claimed_to (if they're emails)
        Schema::table('claims', function (Blueprint $table) {
            if (Schema::hasColumn('claims', 'claimed_by')) {
                $table->dropColumn('claimed_by');
            }
            if (Schema::hasColumn('claims', 'claimed_to')) {
                $table->dropColumn('claimed_to');
            }
        });

        // Add new claimed_by and claimed_to (as student IDs)
        Schema::table('claims', function (Blueprint $table) {
            $table->unsignedBigInteger('claimed_by')->after('id');
            $table->unsignedBigInteger('claimed_to')->after('claimed_by');

            $table->foreign('claimed_by')->references('id')->on('students')->onDelete('cascade');
            $table->foreign('claimed_to')->references('id')->on('students')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->dropForeign(['claimed_by']);
            $table->dropForeign(['claimed_to']);
            $table->dropColumn(['claimed_by', 'claimed_to']);
        });
    }
}


