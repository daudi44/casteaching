<?php

use App\Models\Team;
use App\Models\User;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

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

        $user -> superadmin = true;
        $user -> save();

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
            'title' => 'playlist para estudar como um filósofo medieval tendo revelação da verdade pela graça divina',
            'description' => '**Se quer mais conteúdo como esse, dê uma CURTIDA nesse vídeo e clique em INSCREVER-SE!**  Fiz essa playlist para quem quer estudar como um filósofo medieval tendo revelação da verdade pela graça divina. Discípulos de Tomás de Aquino, Santo Agostinho, Santo Anselmo que têm a verdade revelada pela graça divina, compartilhem esse vídeo para todos os polos do reino de Deus.',
            'url' => 'https://youtu.be/w8j07_DBl_I',
            'published_at' => Carbon::parse('December 13, 2020 8:00pm'),
            'previous' => null,
            'next' => null,
            'series_id' => 1
        ]);
    }
}

if(! function_exists('create_regular_user')){
    function create_regular_user()
    {
        $user = User::create([
            'name' => 'RegularUser',
            'email' => 'regular@casteaching.com',
            'password' => Hash::make('12345')
        ]);

        add_personal_team($user);

        return $user;
    }
}

if(! function_exists('create_video_manager_user')) {
    function create_video_manager_user()
    {
        $user = User::create([
            'name' => 'VideosManager',
            'email' => 'videosmanager@casteaching.com',
            'password' => Hash::make('12345')
        ]);
        Permission::create(['name' => 'videos_manage_index']);
        $user -> givePermissionTo('videos_manage_index');
        add_personal_team($user);
        return $user;
    }
}

if(! function_exists('create_superadmin_user')){
    function create_superadmin_user()
    {
        $user = User::create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@casteaching.com',
            'password' => Hash::make('12345')
        ]);

        $user -> superadmin = true;
        $user -> save();

        add_personal_team($user);

        return $user;
    }
}

if(! function_exists('define_gates')) {
    function define_gates()
    {
        //Declaro la gate conchesumadre
        Gate::before(function($user, $ability){
            if ($user->isSuperAdmin()) return true;
        });

        Gate::define('videos_manage_index', function (User $user) {
            return false;
        });
    }
}

if(! function_exists('create_permissions')) {
    function create_permissions()
    {
        Permission::firstOrCreate(['name' => 'videos_manage_index']);
    }
}
