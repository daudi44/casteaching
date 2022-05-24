<?php

namespace Tests\Feature\Series;

use App\Models\Serie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

/**
 * @covers \App\Http\Controllers\SeriesApiController
 */
class SeriesApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function guest_users_can_index_published_series()
    {
        $series = create_sample_series();

        $response = $this->get('/api/series/');

        $response->assertStatus(200);

        $response->assertJsonCount(count($series));
    }

    /**
     * @test
     */
    public function guest_users_can_show_published_series()
    {
        $serie = Serie::create([
            'title' => 'dannyexample',
            'description' => 'dannyexample',
            'image' => 'dannyexample.jpg',
            'teacher_name' => 'Pakistani Danny',
            'teacher_photo_url' => 'https://gravatar.com/avatar/' . md5('daudi@iesebre.com')
        ]);

        $response = $this->getJson('/api/series/'.$serie->id);

        $response->assertStatus(200);

        $response->assertSee($serie->title);
        $response->assertSee($serie->description);
        $response->assertSee($serie->image);
        $response->assertSee($serie->teacher_name);
        $response->assertSee('https:\/\/gravatar.com\/avatar\/73710609025beef09380e17557448b6c');

        $response
            ->assertJson(fn(AssertableJson $json)=>

            $json->where('id',$serie->id)
                ->where('title',$serie->title)
                ->where('description',$serie->description)
                ->where('image',$serie->image)
                ->where('teacher_name',$serie->teacher_name)
                ->where('teacher_photo_url',$serie->teacher_photo_url)
                ->etc()
        );
    }

    /**
     * @test
     */
    public function guest_users_cannot_show_unexisting_series()
    {
        $response = $this->get('/api/series/999');

        $response->assertStatus(404);
    }
}
