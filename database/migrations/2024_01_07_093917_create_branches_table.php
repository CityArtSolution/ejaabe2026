<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name')>nullable();
            $table->string('phone_number');
            $table->string('email');
            $table->string('address')->nullable();
             $table->string('location')->nullable();
             $table->string('subdomain')->nullable();
             $table->string('home_page')->nullable();
             $table->string('currency')->nullable();

            $table->tinyInteger('status')->default(1);
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
}