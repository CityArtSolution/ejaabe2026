<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->nullable();
            $table->decimal('discounted_price', 8, 2)->nullable();
            $table->json('what_you_will_learn')->nullable(); // JSON field
            $table->json('event_content')->nullable(); // JSON field
            

        });
    }
      
    
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('price');
            $table->dropColumn('discounted_price');
            $table->dropColumn('what_you_will_learn');
            $table->dropColumn('event_content');
            
        });
    }
    
}
