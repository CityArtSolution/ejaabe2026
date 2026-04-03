<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_translations', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->bigIncrements('id');
            $table->unsignedBigInteger('event_id');
            $table->string('locale', 191)->index();
            $table->string('title');
            $table->text('location')->nullable();
            $table->longText('what_you_will_learn')->nullable();
            $table->longText('event_content')->nullable();
            $table->longText('details')->nullable();

            $table->foreign('event_id')->on('events')->references('id')->onDelete('cascade');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('location');
            $table->dropColumn('what_you_will_learn');
            $table->dropColumn('event_content');

            $table->dropColumn('details');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webinar_translations');
    }
}
