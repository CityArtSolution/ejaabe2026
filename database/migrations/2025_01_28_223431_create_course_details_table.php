<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
        public function up()
        {
            Schema::create('course_details', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('webinar_id');
                $table->string('date');
                $table->string('location');
                $table->decimal('price', 8, 2);
                $table->string('lang')->nullable();
                $table->string('ndays')->nullable();
                $table->string('start_time')->nullable();
                 $table->string('end_time')->nullable();

                $table->timestamps();
    
                $table->foreign('webinar_id')->references('id')->on('webinars')->onDelete('cascade');
            });
        }
    
        public function down()
        {
            Schema::dropIfExists('course_details');
        }
    }
