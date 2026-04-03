<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_translations', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->bigIncrements('id');
            $table->unsignedInteger('branch_id');
            $table->string('locale', 191)->index();
            $table->string('name');
            $table->string('address')->nullable();

            $table->foreign('branch_id')->on('branches')->references('id')->onDelete('cascade');
        });

        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('name');
            $table->dropColumn('address');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branch_translations');
    }
}
