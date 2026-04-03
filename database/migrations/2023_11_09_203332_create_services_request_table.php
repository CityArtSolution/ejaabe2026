<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesRequestTable extends Migration
{
    
        public function up()
        {
            Schema::create('service_requests', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('phone');
                $table->text('description')->nullable();
                $table->enum('type', ['course', 'consulting']);

                $table->timestamps();
            });
        }
    
        public function down()
        {
            Schema::dropIfExists('service_requests');
        }
    }