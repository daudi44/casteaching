<?php

namespace Tests\Unit;

use App\Models\User;
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
}
