<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAttachedAndLinkToWebinarExtraDescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webinar_extra_descriptions', function (Blueprint $table) {
            $table->string('attached')->nullable();
            $table->string('link')->nullable()->after('attached');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webinar_extra_descriptions', function (Blueprint $table) {
            $table->dropColumn(['attached', 'link']);
        });
    }
}