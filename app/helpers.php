<?php

use App\Models\Team;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

if(! function_exists('create_default_user')){
    function create_default_user(){
        $user = User::create([
            'name' => config('casteaching.default_user.name', 'Sergi Tur Badenas'),
            'email' => config('casteaching.default_user.email','sergiturbadenas@gmail.com'),
            'password' => Hash::make(config('casteaching.default_user.password','12345678'))
        ]);

        add_personal_team($user);
    }
}

if(! function_exists('create_student_user')){
    function create_student_user(){
        $user = User::create([
            'name' => 'Daniel Audí Bielsa',
            'email' => 'daudi@iesebre.com',
            'password' => Hash::make('dani12345')
        ]);

        add_personal_team($user);
    }
}

if (! function_exists('add_personal_team')) {
    /**
     * @param $user
     */
    function add_personal_team($user): void
    {
        try {
            Team::forceCreate([
                'name' => $user->name . "'s Team",
                'user_id' => $user->id,
                'personal_team' => true
            ]);
        } catch (\Exception $exception) {
//            dd($exception->getMessage());
        }
    }
}

if(! function_exists('create_default_videos')){
    function create_default_videos(){
        Video::create([
            'title' => 'Ubuntu 101',
            'description' => '# Here description',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'series_id' => 1
        ]);
    }
}
