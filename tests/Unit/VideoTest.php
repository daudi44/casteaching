<?php

namespace Tests\Unit;

use App\Models\Serie;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * @covers Video::class
 */
class VideoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function video_can_need_subscription()
    {
        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => 'Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
        ]);

        $this->assertNull($video->needs_subscription);

        $video->markOnlyForSubscribers();

        $video->refresh();

        $this->assertNotNull($video->needs_subscription);
    }

    /**
     * @test
     */
    public function can_check_if_video_can_be_displayed()
    {
        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => 'Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
        ]);

        $this->assertTrue($video->canBeDisplayed());

        $video->markOnlyForSubscribers();
        $video->refresh();

        $this->assertFalse($video->canBeDisplayed());
    }

    /**
     * @test
     */
    public function can_check_if_a_video_need_subscriber()
    {
        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => 'Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
        ]);

        $this->assertFalse($video->only_for_subscribers);

        $video->markOnlyForSubscribers();

        $video->refresh();

        $this->assertTrue($video->only_for_subscribers);
    }


    /**
     * @test
     */
    public function can_get_formated_published_at_date()
    {
        //1-Preparació
        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => 'Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'serie_id' => 1
        ]);

        //2-Execució
        $dateToTest = $video -> formated_published_at;

        //3-Comprovació
        $this->assertEquals($dateToTest, '13 de desembre de 2020');
    }

    /**
     * @test
     */
    public function can_get_formated_published_at_date_when_not_published()
    {
        //1-Preparació
        $video = Video::create([
            'title' => 'Ubuntu 101',
            'description' => 'Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => null,
            'previous' => null,
            'next' => null,
            'serie_id' => 1
        ]);

        //2-Execució
        $dateToTest = $video -> formated_published_at;

        //3-Comprovació
        $this->assertEquals($dateToTest, '');
    }

    /**
     * @test
     */
    public function video_have_serie()
    {
        //Preparació
        $video = Video::create([
            'title' => 'asdf',
            'description' => 'asdfasdf',
            'url' => 'asdfasdf'
        ]);

        //Comprovació
        $this->assertNull($video->serie);

        $serie = Serie::create([
            'title' => 'Estudio como filósofos',
            'description' => 'Una serie de vídeos con música clásica para estudiar de la misma manera que como lo hacían los antiguos filosofos.',
            'image' => 'umadelisia.jpg',
            'teacher_name' => 'Pakistani Danny',
            'teacher_photo_url' => 'https://gravatar.com/avatar/' . md5('daudi@iesebre.com'),
            'created_at' =>Carbon::now()->addSeconds(1)
        ]);

        $video->setSerie($serie);

        $this->assertNotNull($video->fresh()->serie);

//        $this->assertEquals($serie, $video->fresh->serie);
    }

    /**
     * @test
     */
    public function video_can_have_owners()
    {
        $user = User::create([
            'name' => 'Daniel Audí Bielsa',
            'email' => 'dani@casteaching.com',
            'password' => Hash::make('12345678')
        ]);

        $video = Video::create([
            'title' => 'asdf',
            'description' => 'asdfasdf',
            'url' => 'asdfasdf'
        ]);

        $this->assertNull($video->owner);
        $video->setOwner($user);
        $this->assertNotNull($video->fresh()->user);
        $this->assertEquals($video->user->id,$user->id);
    }
}
