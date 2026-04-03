<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWebinarsToRegistrationPackagesTable extends Migration
{
    public function up()
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->json('webinar_ids')->nullable();
        });
    }

    public function down()
    {
        Schema::table('registration_packages', function (Blueprint $table) {
            $table->dropColumn('webinar_ids');
        });
    }
}