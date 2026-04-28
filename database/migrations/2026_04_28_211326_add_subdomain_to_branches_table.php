<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->string('subdomain')->nullable()->unique()->after('name');
            $table->string('phone_number')->nullable()->after('subdomain');
            $table->string('email')->nullable()->after('subdomain');
            $table->string('address')->nullable()->after('subdomain');
            $table->string('currency')->nullable()->after('subdomain');
            $table->string('location')->nullable()->after('subdomain');
            $table->string('home_page')->nullable()->after('subdomain');



        });
    }

    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->dropColumn('subdomain');
        });
    }
};
