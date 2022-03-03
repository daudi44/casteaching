<?php

namespace Tests\Feature\Videos;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Tests\Traits\CanLogin;

class VideosManageVueControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;

    /**
     * @test
     */
    public function user_with_permission_can_manage_videos()
    {
        $this->loginAsVideoManager();

        $videos = create_sample_videos();

        $response = $this->get('/vue/manage/videos');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.vue.index');

        $response->assertViewMissing('videos');

        foreach ($videos as $video) {
            $response->assertSee($video->id);
//            $response->assertSee($video->title);
        }
    }

    /** @test */
    public function regular_users_cannot_manage_videos()
    {
        $this->loginAsRegularUser();
        $response = $this->get('/vue/manage/videos');
        $response->assertstatus(403);
    }

    /** @test */
    public function guest_users_cannot_manage_videos()
    {
        $response = $this->get('/vue/manage/videos');
        $response->assertRedirect(route('login'));
    }
}
