<?php

namespace Tests\Feature\Videos;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * @covers  \App\Http\Controllers\VideosManageController
 */
class UsuarisManageControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function user_with_permissions_can_manage_users()
    {
        $this->loginAsUserManager();

        $users = create_sample_users();

        $response = $this->get('/manage/users');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index_usuaris');
        $response->assertViewHas('users',function($v) use ($users){
            return $users->count() === $users->count() && get_class($users) === Collection::class &&
                get_class($users[0]) === User::class;
        });

        foreach ($users as $user) {
            $response->assertSee($user->id);
            $response->assertSee($user->name);
            $response->assertSee($user->email);
        }
    }

    /**
     * @test
     */
    public function superadmins_can_manage_videos()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/manage/users');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index_usuaris');
    }

    /**
     * @test
     */
    public function regular_users_cannot_manage_videos(){
        $this->loginAsRegularUser();

        $response = $this->get('/manage/users');

        $response -> assertStatus(403);
//        $response -> assertRedirect(route('dashboard'));
    }

    /**
     * @test
     */
    public function guest_users_cannot_manage_videos(){
        $response = $this->get('/manage/users');

        $response -> assertRedirect(route('login'));
    }

    private function loginAsUserManager()
    {
        Auth::login(create_user_manager_user());
    }

    private function loginAsSuperAdmin()
    {
        Auth::login(create_superadmin_user());
    }

    private function loginAsRegularUser()
    {
        Auth::login(create_regular_user());
    }
}
