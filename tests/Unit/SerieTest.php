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
}
