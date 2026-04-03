<?php
namespace App\Services;

//use Vimeo\Vimeo;

class VimeoService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Vimeo(
            env('VIMEO_CLIENT_ID'),
            env('VIMEO_CLIENT_SECRET'),
            env('VIMEO_ACCESS_TOKEN')
        );
    }

    public function getVideos()
    {
        $response = $this->client->request('/me/videos', ['per_page' => 100], 'GET');
        return $response['body']['data'];
    }
}