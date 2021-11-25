<?php

namespace Tests\Feature\Videos;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase;

    //Happy path

    /**
     * @test
     */
    public function user_with_permissions_can_manage_videos()
    {
        //1-Preparar
        $this->loginAsVideoManager();

        //2-Executar
        $response = $this->get('/manage/videos');

        //3-Provar
        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function superadmins_can_manage_videos()
    {
        //1-Preparar
        $this->loginAsSuperAdmin();

        //2-Executar
        $response = $this->get('/manage/videos');

        //3-Provar
        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');
    }

    /**
     * @test
     */
    public function guest_users_cannot_manage_videos(){
        $response = $this->get('/manage/videos');

        $response -> assertStatus(200);
    }

    private function loginAsVideoManager()
    {
        $user = User::create([
           'name' => 'VideosManager',
            'email' => 'videosmanager@casteaching.com',
            'password' => Hash::make('12345')
        ]);

        Auth::login($user);

    }

    private function loginAsSuperAdmin()
    {
        Auth::login(create_superadmin_user());
    }
}
