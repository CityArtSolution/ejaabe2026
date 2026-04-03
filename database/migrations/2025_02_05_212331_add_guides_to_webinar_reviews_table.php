<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuidesToWebinarReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('webinar_reviews', function (Blueprint $table) {
        
            $table->integer('guides')->length(10)->after('support_quality'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('webinar_reviews', function (Blueprint $table) {
           
            $table->dropColumn('guides');
        });
    }
}