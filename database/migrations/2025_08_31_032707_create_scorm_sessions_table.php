<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('scorm_sessions')) {
            Schema::create('scorm_sessions', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id')->nullable();
                $table->unsignedBigInteger('webinar_id')->nullable();
                $table->string('session_id')->unique();
                $table->json('data')->nullable();
                $table->boolean('completed')->default(false);
                $table->float('score')->nullable();
                $table->timestamp('initialized_at')->nullable();
                $table->integer('quiz_result_id')->unsigned()->nullable();
                $table->timestamp('last_interaction_at')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('scorm_sessions');
    }
};
