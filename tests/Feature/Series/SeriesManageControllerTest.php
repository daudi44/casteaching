<?php

namespace Tests\Feature\Series;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SeriesManageControllerTest extends TestCase
{
    /**
     * @test
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(500);
    }
}
