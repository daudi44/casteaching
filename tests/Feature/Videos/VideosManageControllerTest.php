<?php

namespace Tests\Feature\Videos;

use App\Events\VideoCreated;
use App\Models\Serie;
use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;
use Tests\Traits\CanLogin;

/**
 * @covers  \App\Http\Controllers\VideosManageController
 */
class VideosManageControllerTest extends TestCase
{
    use RefreshDatabase, CanLogin;
    /**
     * @test
     */
    public function user_with_permissions_can_update_videos(){
        $this->loginAsVideoManager();

        $video = Video::create([
            'title' => 'asdf',
            'description' => 'asdfasdf',
            'url' => 'asdfasdf'
        ]);

        $response = $this->put('/manage/videos/' . $video->id,[
            'title' => 'hola',
            'description' => 'adeu',
            'url' => 'bye'
        ]);

        $response->assertRedirect(route('manage.videos'));
        $response->assertSessionHas('status', 'Successfully changed');

        $newVideo = Video::find($video->id);
        $this->assertEquals('hola', $newVideo->title);
        $this->assertEquals('adeu', $newVideo->description);
        $this->assertEquals('bye', $newVideo->url);
    }

    /**
     * @test
     */
    public function user_with_permissions_can_see_edit_videos(){
        $this->loginAsVideoManager();

        $video = Video::create([
            'title' => '',
            'description' => '',
            'url' => ''
        ]);

        $response = $this->get('/manage/videos/' . $video->id);

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.edit');
        $response->assertViewHas('video', function ($v) use ($video){
            return $video->is($v);
        });
        $response->assertSee('<form data-qa="form_video_edit"',false);

        $response->assertSeeText($video->title);
        $response->assertSeeText($video->description);
        $response->assertSeeText($video->url);
    }

    /**
     * @test
     */
    public function user_with_permissions_can_destroy_videos(){
        $this->loginAsVideoManager();

        $video = Video::create([
            'title' => '',
            'description' => '',
            'url' => ''
        ]);

        $response = $this->delete('/manage/videos/' . $video->id);

        $response->assertRedirect(route('manage.videos'));
        $this->assertNull(Video::find($video->id));
        $this->assertNull($video->refresh);
        $response->assertSessionHas('status', 'Successfully deleted');
    }

    /**
     * @test
     */
    public function user_without_permissions_cannot_destroy_videos(){
        $this->loginAsRegularUser();

        $video = Video::create([
            'title' => '',
            'description' => '',
            'url' => ''
        ]);

        $response = $this->delete('/manage/videos/' . $video->id);

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function user_with_permissions_can_store_videos(){
        $this->loginAsVideoManager();

        $video = objectify($videoArray = [
            'title' => 'Prova',
            'description' => 'bla bla',
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
        ]);

        Event::fake();

        $response = $this->post('/manage/videos',$videoArray);

        Event::assertDispatched(VideoCreated::class);

        $response->assertRedirect(route('manage.videos'));
        $response->assertSessionHas('success', 'Successfully added');

        $videoDB = Video::first();

        $this->assertNotNull($videoDB);
        $this->assertEquals($videoDB->title,$video->title);
        $this->assertEquals($videoDB->description,$video->description);
        $this->assertEquals($videoDB->url,$video->url);
        $this->assertNull($video->published_at);
    }

    /**
     * @test
     */
    public function user_with_permissions_can_store_videos_with_serie(){
        $this->loginAsVideoManager();

        $serie = Serie::create([
            'title' => 'Estudio como filósofos',
            'description' => 'Una serie de vídeos con música clásica para estudiar de la misma manera que como lo hacían los antiguos filosofos.',
            'image' => 'umadelisia.jpg',
            'teacher_name' => 'Pakistani Danny',
            'teacher_photo_url' => 'https://gravatar.com/avatar/' . md5('daudi@iesebre.com')
        ]);

        $video = objectify($videoArray = [
            'title' => 'Prova',
            'description' => 'bla bla',
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'serie_id' => $serie->id
        ]);

        Event::fake();

        $response = $this->post('/manage/videos',$videoArray);

        Event::assertDispatched(VideoCreated::class);

        $response->assertRedirect(route('manage.videos'));
        $response->assertSessionHas('success', 'Successfully added');

        $videoDB = Video::first();

        $this->assertNotNull($videoDB);
        $this->assertEquals($videoDB->title,$video->title);
        $this->assertEquals($videoDB->description,$video->description);
        $this->assertEquals($videoDB->url,$video->url);
        $this->assertEquals($videoDB->serie_id,$serie->id);
        $this->assertNull($video->published_at);
    }

    /**
     * @test
     */
    public function user_with_permissions_can_store_videos_with_user_id()
    {

        $this->loginAsVideoManager();

        $user = User::create([
            'name' => 'Daniel Audí Bielsa',
            'email' => 'dani@casteaching.com',
            'password' => Hash::make('12345678')
        ]);

        $video = objectify($videoArray = [
            'title' => 'Prova',
            'description' => 'bla bla',
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'user_id' => $user->id
        ]);

        Event::fake();
        $response = $this->post('/manage/videos',$videoArray);

        Event::assertDispatched(VideoCreated::class);

        $response->assertRedirect(route('manage.videos'));
//        $response->assertSessionHas('status', 'Successfully created');

        $videoDB = Video::first();

        $this->assertNotNull($videoDB);
        $this->assertEquals($videoDB->title,$video->title);
        $this->assertEquals($videoDB->description,$video->description);
        $this->assertEquals($videoDB->url,$video->url);
//        $this->assertEquals($videoDB->user_id,$user->id);
        $this->assertNull($video->published_at);

    }

    /**
     * @test
     */
    public function user_without_permissions_cannot_store_videos(){
        $this->loginAsRegularUser();

        $response = $this->post('/manage/videos',[
            'title' => 'Prova',
            'description' => 'bla bla',
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ'
        ]);

        $response->assertStatus(403);
    }

    /**
     * @test
     */
    public function user_with_permissions_can_destroy_users(){
        $this->loginAsUserManager();

        $user = User::create([
            'name' => 'Sujeto De Pruebas',
            'email' => 'sujetodepruebas@casteaching.com',
            'password' => Hash::make(12345)
        ]);

        $response = $this->delete('/manage/users/' . $user->id);

        $response->assertRedirect(route('manage.users'));
        $this->assertNull(Video::find($user->id));
        $this->assertNull($user->refresh);
        $response->assertSessionHas('status', 'Successfully deleted');
    }

    /**
     * @test
     */
    public function user_with_permissions_can_store_users(){
        $this->loginAsUserManager();

        $user = objectify([
            'name' => 'Sujeto De Pruebas',
            'email' => 'sujetodepruebas@casteaching.com',
            'password' => Hash::make(12345)
        ]);

        $response = $this->post('/manage/users',[
            'name' => 'Sujeto De Pruebas',
            'email' => 'sujetodepruebas@casteaching.com',
            'password' => Hash::make(12345)
        ]);

        $response->assertRedirect(route('manage.users'));
        $response->assertSessionHas('success', 'Successfully added');

        $userDB = User::first();

        $this->assertNotNull($userDB);
        $this->assertEquals($userDB->title,$user->title);
        $this->assertEquals($userDB->description,$user->description);
        $this->assertEquals($userDB->url,$user->url);
        $this->assertNull($user->published_at);
    }

    /**
     * @test
     */
    public function user_with_permissions_can_see_add_videos(){
        $this->loginAsVideoManager();

        $response = $this->get('/manage/videos');

        $response->assertStatus(200);

        $response->assertViewIs('videos.manage.index');

        $response->assertSee('form data-qa="form_video_add"',false);
    }

    /**
     * @test
     */
    public function user_without_add_permission_cannot_see_add_videos(){
        Permission::firstOrCreate(['name' => 'videos_manage_index']);

        $user = User::create([
            'name' => 'Moniato',
            'email' => 'moniato@casteaching.com',
            'password' => Hash::make('12345')
        ]);

        $user->givePermissionTo('videos_manage_index');

        add_personal_team($user);

        Auth::login($user);

        $response = $this->get('/manage/videos');
        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');
        $response->assertDontSee('<form data-qa="form_video_add"',false);
    }

    /**
     * @test
     */
    public function user_with_permissions_can_manage_videos()
    {
        $this->loginAsVideoManager();

        $videos = create_sample_videos();

        $response = $this->get('/manage/videos');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');
        $response->assertViewHas('videos',function($v) use ($videos){
            return $videos->count() === $videos->count() && get_class($videos) === Collection::class &&
                get_class($videos[0]) === Video::class;
        });

        foreach ($videos as $video) {
            $response->assertSee($video->id);
            $response->assertSee($video->title);
        }
    }

    /**
     * @test
     */
    public function user_with_permissions_can_manage_videos_and_see_serie()
    {
        $this->loginAsVideoManager();

        $videos = create_sample_videos();

        $serie = Serie::create([
            'title' => 'Estudio como filósofos',
            'description' => 'Una serie de vídeos con música clásica para estudiar de la misma manera que como lo hacían los antiguos filosofos.',
            'image' => 'umadelisia.jpg',
            'teacher_name' => 'Pakistani Danny',
            'teacher_photo_url' => 'https://gravatar.com/avatar/' . md5('daudi@iesebre.com')
        ]);

        $videos[0]->setSerie($serie);

        $response = $this->get('/manage/videos');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');
        $response->assertViewHas('videos',function($v) use ($videos){
            return $videos->count() === $videos->count() && get_class($videos) === Collection::class &&
                get_class($videos[0]) === Video::class;
        });

        foreach ($videos as $video) {
            $response->assertSee($video->id);
            $response->assertSee($video->title);
        }
        $response->assertSee($videos[0]->fresh()->serie->title);
    }


    /**
     * @test
     */
    public function superadmins_can_manage_videos()
    {
        $this->loginAsSuperAdmin();

        $response = $this->get('/manage/videos');

        $response->assertStatus(200);
        $response->assertViewIs('videos.manage.index');
    }

    /**
     * @test
     */
    public function regular_users_cannot_manage_videos(){
        $this->loginAsRegularUser();

        $response = $this->get('/manage/videos');

        $response -> assertStatus(403);
//        $response -> assertRedirect(route('dashboard'));
    }

    /**
     * @test
     */
    public function guest_users_cannot_manage_videos(){
        $response = $this->get('/manage/videos');

        $response -> assertRedirect(route('login'));
    }

    /**
     * @test
     */
    public function title_is_required(){
        $this->loginAsVideoManager();

        $response = $this->post('/manage/videos',[
           'description' => 'dannyexample',
           'url' => 'https://www.youtube.com/watch?v=7FG7nTUYowQ'
        ]);

        $response -> assertSessionHasErrors(['title']);
    }

    /**
     * @test
     */
    public function description_is_required(){
        $this->loginAsVideoManager();

        $response = $this->post('/manage/videos',[
            'title' => 'dannyexample',
            'url' => 'https://www.youtube.com/watch?v=7FG7nTUYowQ'
        ]);

        $response -> assertSessionHasErrors(['description']);
    }

    /**
     * @test
     */
    public function url_is_required(){
        $this->loginAsVideoManager();

        $response = $this->post('/manage/videos',[
            'title' => 'dannyexample',
            'description' => 'dannyexample',
        ]);

        $response -> assertSessionHasErrors(['url']);
    }
}
