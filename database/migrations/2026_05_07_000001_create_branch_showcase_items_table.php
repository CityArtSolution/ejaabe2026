<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('branch_showcase_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->string('section', 50);
            $table->string('page', 20)->default('both');
            $table->string('title')->nullable();
            $table->text('image');
            $table->string('link')->nullable();
            $table->unsignedInteger('order')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->index(['branch_id', 'section', 'page', 'status']);
        });

        $now = now();
        $partners = [
            'https://ejaabi.com/public/uploads/main/images/02-12-2023/656ae01bdedbe.jpeg',
            'https://ejaabi.com/public/uploads/main/images/02-12-2023/656ae4cda1168.png',
            'https://ejaabi.com/public/uploads/main/images/27-12-2023/658c10b1e31d2.png',
            'https://ejaabi.com/public/uploads/main/images/04-12-2023/656e2faf5e7a3.jpeg',
            'https://ejaabi.com/public/uploads/main/images/19-05-2024/6649ba3691866.jpg',
            'https://ejaabi.com/public/uploads/main/images/19-05-2024/6649bdb36f0cd.png',
        ];
        $clients = [
            'https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfeaca39a58.jpeg',
            'https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfefa364dfb.jpeg',
            'https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfea64e8494.jpeg',
            'https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfeac220c6e.jpeg',
            'https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfeb708b082.png',
        ];
        $canadaPartners = [
            'https://ejaabi.com/public/uploads/main/images/22-05-2024/664d96b0442a6.jpeg',
            'https://ejaabi.com/public/uploads/main/images/22-05-2024/664d96d1d67c1.png',
            'https://ejaabi.com/public/uploads/main/images/22-05-2024/664d96deb01c4.png',
            'https://ejaabi.com/public/uploads/main/images/02-12-2023/656ae1e67060d.jpeg',
            'https://ejaabi.com/public/uploads/main/images/04-12-2023/656e2faf5e7a3.jpeg',
            'https://ejaabi.com/public/uploads/main/images/19-05-2024/6649ba3691866.jpg',
            'https://ejaabi.com/public/uploads/main/images/27-12-2023/658c10b1e31d2.png',
        ];
        $canadaClients = [
            'https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfec472cf2d.png',
            'https://ejaabi.com/public/uploads/main/images/09-09-2024/66df29d33d845.jpeg',
            'https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfec5251fe1.png',
            'https://ejaabi.com/public/uploads/main/images/10-09-2024/66dfec66afcda.png',
        ];
        $canadaBranchId = DB::table('branches')->where('subdomain', 'canada')->value('id') ?? 3;
        $branchItems = [
            1 => [
                'partners' => $partners,
                'featured_clients' => $clients,
            ],
            $canadaBranchId => [
                'partners' => $canadaPartners,
                'featured_clients' => $canadaClients,
            ],
        ];

        $rows = [];
        foreach ($branchItems as $branchId => $sections) {
            foreach ($sections['partners'] as $order => $image) {
                $rows[] = [
                    'branch_id' => $branchId,
                    'section' => 'partners',
                    'page' => 'both',
                    'title' => null,
                    'image' => $image,
                    'link' => null,
                    'order' => $order + 1,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }

            foreach ($sections['featured_clients'] as $order => $image) {
                $rows[] = [
                    'branch_id' => $branchId,
                    'section' => 'featured_clients',
                    'page' => 'both',
                    'title' => null,
                    'image' => $image,
                    'link' => null,
                    'order' => $order + 1,
                    'status' => 1,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        DB::table('branch_showcase_items')->insert($rows);
    }

    public function down()
    {
        Schema::dropIfExists('branch_showcase_items');
    }
};
