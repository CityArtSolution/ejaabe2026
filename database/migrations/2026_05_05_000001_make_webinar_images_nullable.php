<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MakeWebinarImagesNullable extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE `webinars` MODIFY COLUMN `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
        DB::statement("ALTER TABLE `webinars` MODIFY COLUMN `image_cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL");
    }

    public function down()
    {
        DB::table('webinars')->whereNull('thumbnail')->update(['thumbnail' => '']);
        DB::table('webinars')->whereNull('image_cover')->update(['image_cover' => '']);

        DB::statement("ALTER TABLE `webinars` MODIFY COLUMN `thumbnail` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL");
        DB::statement("ALTER TABLE `webinars` MODIFY COLUMN `image_cover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL");
    }
}
