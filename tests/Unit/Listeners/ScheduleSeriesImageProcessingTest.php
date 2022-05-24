<?php

namespace Tests\Unit\Listeners;

use App\Events\SeriesImageUpdated;
use App\Jobs\ProcessSeriesImage;
use Tests\TestCase;
use App\Listeners\ScheduleSeriesImageProcessing;
use App\Models\Serie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

/**
 * @covers ScheduleSeriesImageProcessing::class
 */
class ScheduleSeriesImageProcessingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function it_not_queues_a_job_to_process_series_image_if_image_not_exists()
    {
        Queue::fake();

        $serie = Serie::create([
            'title' => 'test events',
            'description' => 'test'
        ]);

        SeriesImageUpdated::dispatch($serie);

        Queue::assertNotPushed(ProcessSeriesImage::class);
    }

    /**
     * @test
     */
    public function it_queues_a_job_to_process_series_image()
    {
        Queue::fake();

        $serie = Serie::create([
            'title' => 'test events',
            'description' => 'test',
            'image' => 'series/test.png'
        ]);

        SeriesImageUpdated::dispatch($serie);

        Queue::assertPushed(ProcessSeriesImage::class, function($job) use($serie){
            return $serie->is($job->serie);
        });
    }
}