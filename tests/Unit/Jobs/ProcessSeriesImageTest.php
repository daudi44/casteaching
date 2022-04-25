<?php

namespace Tests\Unit\Jobs;

use App\Jobs\ProcessSeriesImage;
use App\Models\Serie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\TestCase;

/*
 * @covers ProcessSeriesImage::class
 */
class ProcessSeriesImageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_resizes_the_series_image_to_400px_height()
    {
        Storage::fake('public');

        Storage::disk('public')->put('series/test.jpg', file_get_contents(base_path('tests/Fixtures/11111111.jpg')));

        $serie = Serie::create([
            'title' => 'test events',
            'description' => 'test',
            'image' => 'series/test.jpg'
        ]);

        ProcessSeriesImage::dispatch($serie);

        $resizedImage = Storage::disk('public')->get('series/test.jpg');

        list($width) = getimagesizefromstring($resizedImage);

        $this->assertEquals(400,$width);
    }
}
