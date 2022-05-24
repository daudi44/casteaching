<?php

namespace Tests\Feature\Videos;

use App\Models\Serie;
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
    public function users_can_view_videos_without_serie(){
        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => 'Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'serie_id' => null
        ]);

        //Fase 2 execució
        $response = $this->get('/videos/' . $video->id);
        //Fase 3 comprovacions
        $response->assertStatus(200);
        $response->assertSee($video->title);
        $response->assertSee($video->description);
        $response->assertSee($video->url);

        $response->assertDontSee('<div id="layout_series_navigation"',false);
    }

    /**
     * @test
     */
    public function users_can_view_video_series_navigation(){
        $serie = Serie::create([
            'title' => 'Test',
            'description' => 'Test',
            'teacher_name' => 'Daniel Audí Bielsa'
        ]);

        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => 'Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'serie_id' => $serie->id
        ]);
        $response = $this->get('/videos/' . $video->id);
        $response->assertStatus(200);
        $response->assertSee($video->title);
        $response->assertSee($video->description);
        $response->assertSee($video->url);
        $response->assertSee($serie->title);
        $response->assertSee($serie->teacher_name);
    }

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
            'serie_id' => 1
        ]);
        //Fase 2 execució
        $response = $this->get('/videos/' . $video->id);
        //Fase 3 comprovacions
        $response->assertStatus(200);
        $response->assertSee('Ubuntu 101');
        $response->assertSee('Here description');
        $response->assertSee('https://youtu.be/w8j07_DBl_I');
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
