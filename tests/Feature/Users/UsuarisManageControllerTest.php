<?php

namespace Tests\Feature\Users;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
    public function user_with_permissions_can_update_videos(){
        $this->loginAsUserManager();

        $user = User::create([
            'name' => 'Manolo',
            'email' => 'manolo@casteaching.com',
            'password' => 'manolo12345'
        ]);

        $response = $this->put('/manage/users/' . $user->id,[
            'name' => 'Pepito',
            'email' => 'pepito@casteaching.com',
            'password' => 'pepito12345'
        ]);

        $response->assertRedirect(route('manage.users'));
        $response->assertSessionHas('status', 'Successfully changed');

        $newUser = User::find($user->id);
        $this->assertEquals('Pepito', $newUser->name);
        $this->assertEquals('pepito@casteaching.com', $newUser->email);
    }

    /**
     * @test
     */
    public function user_with_permissions_can_see_edit_videos(){
        $this->loginAsUserManager();

        $user = User::create([
            'name' => '',
            'email' => '',
            'password' => ''
        ]);

        $response = $this->get('/manage/users/' . $user->id);

        $response->assertStatus(200);
        $response->assertViewIs('users.manage.edit_usuaris');
        $response->assertViewHas('user', function ($v) use ($user){
            return $user->is($v);
        });
        $response->assertSee('<form data-qa="form_user_edit"',false);

        $response->assertSeeText($user->title);
        $response->assertSeeText($user->description);
        $response->assertSeeText($user->url);
    }

    /**
     * @test
     */
    public function user_with_permissions_can_manage_users()
    {
        $this->loginAsUserManager();

        $users = create_sample_users();

        $response = $this->get('/manage/users');

        $response->assertStatus(200);
        $response->assertViewIs('users.manage.index_usuaris');
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
        $response->assertViewIs('users.manage.index_usuaris');
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
