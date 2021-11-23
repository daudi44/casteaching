<?php

namespace Tests\Feature\Videos;

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\VideosController
 */


class VideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function users_can_view_videos()
    {
        //Fase 1 preparació
        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => 'Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'series_id' => 1
        ]);
        //Fase 2 execució
        $response = $this->get('/videos/' . $video->id);
        //Fase 3 comprovacions
        $response->assertStatus(200);
        $response->assertSee('Ubuntu 101');
        $response->assertSee('Here description');
        $response->assertSee('13 de desembre de 2020');
    }

    /**
     * @test
     */
    public function users_cannot_view_non_existing_videos()
    {
        $response = $this->get('/videos/999');
        $response->assertStatus(404);
    }
}
