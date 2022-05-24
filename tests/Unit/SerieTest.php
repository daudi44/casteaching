<?php

namespace Tests\Unit;

use App\Models\Serie;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\Models\Serie
 */
class SerieTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function serie_have_videos()
    {
        $firstSerie = Serie::create([
            'title' => 'Estudio como filósofos',
            'description' => 'Una serie de vídeos con música clásica para estudiar de la misma manera que como lo hacían los antiguos filosofos.',
            'image' => 'umadelisia.jpg',
            'teacher_name' => 'Pakistani Danny',
            'teacher_photo_url' => 'https://gravatar.com/avatar/' . md5('daudi@iesebre.com'),
            'created_at' =>Carbon::now()->addSeconds(1)
        ]);

        $this->assertNotNull($firstSerie->videos);
        $this->assertCount(0, $firstSerie->videos);

        $video = Video::create([
            'title' => 'asdf',
            'description' => 'asdfasdf',
            'url' => 'asdfasdf',
            'serie_id'=>$firstSerie->id
        ]);

        $firstSerie->refresh();
        $this->assertNotNull($firstSerie->videos);
        $this->assertCount(1, $firstSerie->videos);
    }

    /** @test */
    public function series_have_url_linking_to_first_video_serie()
    {
        $serie = Serie::create([
            'title' => 'TDD (Test Driven Development)',
            'description' => 'Bla bla bla'
        ]);

        $video = Video::create([
            'title' => 'Intro to TDD',
            'description' => 'Bla bla bla',
            'serie_id' => $serie->id,
            'url' => 'https://youtu.be/w8j07_DBl_I',

        ]);


        $this->assertNotNull($serie->url);

        $this->assertEquals('/videos/' . $video->id, $serie->url);
    }

    /** @test */
    public function series_have_url_linking_to_nothing_if_no_videos()
    {
        $serie = Serie::create([
            'title' => 'TDD (Test Driven Development)',
            'description' => 'Bla bla bla'
        ]);

        $this->assertNotNull($serie->url);

        $this->assertEquals('#', $serie->url);
    }
}
