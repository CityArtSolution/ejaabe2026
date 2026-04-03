<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovalColumnsToWebinarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webinar_translations', function (Blueprint $table) {
            $table->string('approval_name')->nullable();
        });

        Schema::table('webinars', function (Blueprint $table) {
            $table->string('approval_logo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webinar_translations', function (Blueprint $table) {
            $table->dropColumn('approval_name');

        });

        Schema::table('webinars', function (Blueprint $table) {
            $table->dropColumn('approval_logo');

        });
    }
}
