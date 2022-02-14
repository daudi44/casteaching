<?php

namespace Tests\Feature;

use App\Models\Serie;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * @covers \App\View\Components\CasteachingSeries
 */
class CastechingSeriesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * @test
     */
    public function gust_users_can_see_published_series()
    {
        //Preparació
        $firstSerie = Serie::create([
            'title' => 'Estudio como filósofos',
            'description' => 'Una serie de vídeos con música clásica para estudiar de la misma manera que como lo hacían los antiguos filosofos.',
            'image' => 'umadelisia.jpg',
            'teacher_name' => 'Pakistani Danny',
            'teacher_photo_url' => 'https://gravatar.com/avatar/' . md5('daudi@iesebre.com'),
            'created_at' =>Carbon::now()->addSeconds(1)
        ]);

        $secondSerie = Serie::create([
            'title' => 'Memes and shitpost',
            'description' => 'Una serie repleta de memes recopilados de youtube con la que poder passar un buen rato con tus amigos.',
            'image' => 'momardo.jpeg',
            'teacher_name' => 'Pakistani Danny',
            'teacher_photo_url' => 'https://gravatar.com/avatar/' . md5('daudi@iesebre.com'),
            'created_at' =>Carbon::now()->addSeconds(2)
        ]);

        $thirdSerie = Serie::create([
            'title' => 'Mejores Videojuegos Indie',
            'description' => 'En esta serie podremos encontrar variedad de vídeos que muestran y explican los que se consideran los mejores videojuegos indie de todos los tiempos.',
            'image' => 'videogame.jpeg',
            'teacher_name' => 'Pakistani Danny',
            'teacher_photo_url' => 'https://gravatar.com/avatar/' . md5('daudi@iesebre.com'),
            'created_at' =>Carbon::now()->addSeconds(3)
        ]);

        //Execució
        $view = $this->blade('<x-casteaching-series/>');

        //Comprovació
        $view->assertSeeInOrder([$firstSerie->title, $secondSerie->title, $thirdSerie->title]);
        $view->assertSeeInOrder([$firstSerie->description, $secondSerie->description, $thirdSerie->description]);
        $view->assertSeeInOrder([$firstSerie->teacher_name, $secondSerie->teacher_name, $thirdSerie->teacher_name]);
        $view->assertSeeInOrder([$firstSerie->image, $secondSerie->image, $thirdSerie->image]);
        $view->assertSeeInOrder([$firstSerie->teacher_photo_url, $secondSerie->teacher_photo_url, $thirdSerie->teacher_photo_url]);

    }
}
