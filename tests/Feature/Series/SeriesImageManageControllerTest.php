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
            'image' => $file = UploadedFile::fake()->image('test.png'),
        ]);

        $response->assertRedirect();

        Storage::disk('public')->assertExists('/series/'. $file->hashName());

        $response->assertSessionHas('status', __('Successfully updated'));

        $this->assertEquals($serie->refresh()->image,'series/'.$file->hashName());
        $this->assertNotNull($serie->refresh()->image);
    }
}
