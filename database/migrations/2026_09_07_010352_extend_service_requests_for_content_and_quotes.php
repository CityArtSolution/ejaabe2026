<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            ALTER TABLE service_requests
            MODIFY COLUMN type
            ENUM('course', 'consulting', 'content_development', 'quotation')
            NOT NULL
        ");
        
                Schema::table('service_requests', function (Blueprint $table) {
            if (!Schema::hasColumn('service_requests', 'company')) {
                $table->string('company')->nullable();
            }

            if (!Schema::hasColumn('service_requests', 'branch_id')) {
                $table->unsignedBigInteger('branch_id')->nullable()->index();
            }
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
                if (DB::table('service_requests')
            ->whereIn('type', ['content_development', 'quotation'])
            ->exists()) {
            throw new \RuntimeException(
                'Cannot roll back while content development or quotation requests exist.'
            );
        }

        DB::statement("
            ALTER TABLE service_requests
            MODIFY COLUMN type ENUM('course', 'consulting') NOT NULL
        ");

    }
};
