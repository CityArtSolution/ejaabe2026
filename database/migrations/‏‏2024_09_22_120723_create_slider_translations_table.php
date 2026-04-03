<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSliderTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slider_translations', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->bigIncrements('id');
            $table->unsignedInteger('slider_id');
            $table->string('locale', 191)->index();
            $table->string('title');
            $table->string('button1_title')->nullable();
            $table->string('button2_title')->nullable();
            $table->string('button1_link')->nullable();
            $table->string('button2_link')->nullable();

            $table->longText('description')->nullable();

            $table->foreign('slider_id')->on('sliders')->references('id')->onDelete('cascade');
        });

        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('button1_title');
            $table->dropColumn('button2_title');
            $table->dropColumn('button1_link');
            $table->dropColumn('button2_link');

            $table->dropColumn('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('slider_translations');
    }
}
