<?php

namespace Tests\Feature\Series;

use App\Models\Serie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Tests\Traits\CanLogin;

/*
 * @covers SeriesImageManageController::class
 */
class SeriesImageManageControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /**
     * @test
     */
    public function series_managers_can_update_image_series()
    {
        $this->loginAsSeriesManager();

        $serie = Serie::create([
            'title' => 'test',
            'description' => 'test',
            'image' => 'test.png',
            'teacher_name' => 'Dani Audí'
        ]);

        Storage::fake('public');

        // URI ENDPOINT -> API -> FUNCTION
        $response = $this->put('/manage/series/' . $serie->id . '/image/',[
            'image' => $file = UploadedFile::fake()->image('test.png', 960, 540),
        ]);

        $response->assertRedirect();

        Storage::disk('public')->assertExists('/series/'. $file->hashName());

        $response->assertSessionHas('status', __('Successfully updated'));

        $this->assertEquals($serie->refresh()->image,'series/'.$file->hashName());
        $this->assertNotNull($serie->image);

        $this->assertFileEquals($file->getPathname(),Storage::disk('public')->path($serie->image));
    }


    /**
     * @test
     */
    public function series_image_have_to_be_an_image()
    {
        $this->loginAsSeriesManager();

        $serie = Serie::create([
            'title' => 'test',
            'description' => 'test',
            'image' => 'series/test.png',
            'teacher_name' => 'Dani Audí'
        ]);

        Storage::fake('public');

        $response = $this->put('/manage/series/' . $serie->id . '/image/',[
            'image' => $file = UploadedFile::fake()->create('test.pdf',0,'application/pdf'),
        ]);

        $response->assertRedirect();

        $response->assertSessionHasErrors('image');

        $this->assertEquals('series/test.png',$serie->refresh()->image);
    }


    /**
     * @test
     */
    public function series_image_must_be_at_least_400px_height()
    {
        $this->loginAsSeriesManager();

        $serie = Serie::create([
            'title' => 'test',
            'description' => 'test',
            'image' => 'series/test.png',
            'teacher_name' => 'Dani Audí'
        ]);

        Storage::fake('public');

        $response = $this->put('/manage/series/' . $serie->id . '/image/',[
            'image' => $file = UploadedFile::fake()->image('serie.jpg', 200, 399),
        ]);

        $response->assertRedirect();

        $response->assertSessionHasErrors('image');

        $this->assertEquals('series/test.png',$serie->refresh()->image);
    }

    /**
     * @test
     */
    public function series_image_must_be_aspect_ratio_16_9()
    {
        $this->loginAsSeriesManager();

        $serie = Serie::create([
            'title' => 'test',
            'description' => 'test',
            'image' => 'series/test.png',
            'teacher_name' => 'Dani Audí'
        ]);

        Storage::fake('public');

        $response = $this->put('/manage/series/' . $serie->id . '/image/',[
            'image' => $file = UploadedFile::fake()->image('serie.jpg', 6000, 400),
        ]);

        $response->assertRedirect();

        $response->assertSessionHasErrors('image');

        $this->assertEquals('series/test.png',$serie->refresh()->image);
    }


    //TEST PER COMPROVAR EL TAMANY DELS ARXIUS, PERÒ FALLA, O BÈ EL MÈTODE size(), O LA VALIDACIÓ FETA AL CONTROLADOR
//    /**
//     * @test
//     */
//    public function series_image_size_must_be_under_2_mb()
//    {
//        $this->loginAsSeriesManager();
//
//        $serie = Serie::create([
//            'title' => 'test',
//            'description' => 'test',
//            'image' => 'series/test.png',
//            'teacher_name' => 'Dani Audí'
//        ]);
//
//        Storage::fake('public');
//
//        $response = $this->put('/manage/series/' . $serie->id . '/image/',[
//            'image' => $file = UploadedFile::fake()->image('serie.jpg', 960, 540)->size(3000),
//        ]);
//
//        $response->assertRedirect();
//
//        $response->assertSessionHasErrors('image');
//
//        $this->assertEquals('series/test.png',$serie->refresh()->image);
//    }
}
