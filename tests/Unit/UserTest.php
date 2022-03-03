<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function isSuperAdmin()
    {
        $user = User::create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@casteaching.com',
            'password' => Hash::make('1234')
        ]);

        //Abans de dirli que sigui superadmin, miro que no ho sigui
        $this->assertEquals($user->isSuperAdmin(),false);

        //Ara li dic que si que sigui super admin
        $user->superadmin = true;
        $user->save();

        //Torno a mirar per veure si ara que li hem dit si que ho és
        $this->assertEquals($user->isSuperAdmin(),true);

    }

    /** @test */
    public function user_can_have_owned_videos()
    {
        $user = User::create([
            'name' => 'Daniel Audí Bielsa',
            'email' => 'dani@casteaching.com',
            'password' => Hash::make('12345')
        ]);

        $this->assertCount(0,$user->videos);
        $video  = Video::create([
            'title' => 'example',
            'description' => 'stuff',
            'url' => 'https://www.youtube.com/watch?v=I2srfp8TSrc'
        ]);
        $user->addVideo($video);
        $this->assertCount(1,$user->refresh()->videos);
        $this->assertEquals($video->id,$user->videos[0]->id);
    }
}
