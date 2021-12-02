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
        }catch(\Exception $exception){
            dd($exception->getMessage());
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
        Permission::create(['name' => 'videos_manage_create']);
        Permission::create(['name' => 'videos_manage_destroy']);
        Permission::create(['name' => 'videos_manage_store']);
        $user -> givePermissionTo('videos_manage_index');
        $user -> givePermissionTo('videos_manage_create');
        $user -> givePermissionTo('videos_manage_destroy');
        $user -> givePermissionTo('videos_manage_store');
        add_personal_team($user);
        return $user;
    }
}

//Part del exercici de crear l'apartat d'usuaris d'igual manera que el de videos, per tant aqui baix creo un helper
//que ens ajuda a crear un usuari al que dono els permisos de poder accedir a la modificació dels usuaris totals
if(! function_exists('create_user_manager_user')) {
    function create_user_manager_user()
    {
        $user = User::create([
            'name' => 'UsersManager',
            'email' => 'usersmanager@casteaching.com',
            'password' => Hash::make('dani12345dani')
        ]);
        Permission::create(['name' => 'users_manage_index']);
        Permission::create(['name' => 'users_manage_create']);
        Permission::create(['name' => 'users_manage_destroy']);
        $user -> givePermissionTo('users_manage_index');
        $user -> givePermissionTo('users_manage_create');
        $user -> givePermissionTo('users_manage_destroy');
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
        Permission::firstOrCreate(['name' => 'videos_manage_create']);
        Permission::firstOrcreate(['name' => 'videos_manage_destroy']);
        Permission::firstOrcreate(['name' => 'videos_manage_store']);
        Permission::firstOrcreate(['name' => 'users_manage_create']);
        Permission::firstOrcreate(['name' => 'users_manage_destroy']);
    }
}

if(! function_exists('create_sample_videos')) {
     function create_sample_videos(){
         $video1 = Video::create([
             'title' => 'playlist para estudar como sócrates após descobrir que é o mais sábio pelo oráculo de delfos',
             'description' => '**Se quer mais conteúdo como esse, dê uma CURTIDA nesse vídeo e clique em INSCREVER-SE! Fiz essa playlist para quem quer estudar como Sócrates após descobrir que é o mais sábio pelo Oráculo de Delfos.** Sócrates foi um filósofo com muitos discípulos ricos. Não cobrava um centavo deles — afinal, não era um sofista aproveitador sem escrúpulos barganhista do conhecimento. Entretanto, vivia dormindo, comendo e bebendo na mansão de seus discípulos, e de vez em sempre levava uma quentinha para casa com o que sobrava das festas. Como sabemos, Sócrates não escreveu nenhum livro. Ele inventava as desculpas mais esfarrapadas do mundo para não escrever, como a de que escrever atrapalha a memória (???). Entretanto, teve a sorte de ter um discípulo, Platão, que escreveu detalhadamente vários diálogos inteiros que Sócrates travou com os influencers da época. Evidentemente, Platão não estava presente em todos os diálogos, então perguntava a alguém que estava lá o que foi dialogado e, a partir disso, escrevia os diálogos. Ou seja, os diálogos de Platão possuem a precisão histórica de uma vizinha fofoqueira. Com exceção de Foucault, todos sabemos que os gregos eram gays. Sócrates, entretanto, provavelmente não era, já que negava fogo a Alcibíades, um dos jovens mais cobiçados da Grécia, que só faltava morrer de amores pelo seu daddy. Um dia Alcibíades chegou bebado em uma reunião de filósofos e declarou-se abusivamente para Sócrates na frente de todos, sendo portanto o primeiro gay a ser cancelado pelo LDRV. Sócrates explicou que, enquanto Alcibíades era bonito, ele mesmo era sábio, que "a beleza do corpo não supera a beleza da alma". Como vemos, Sócrates era muito humilde. Por isso, vivia dizendo que o próprio deus Apolo o intitulou como o homem mais sábio do planeta Terra. Uma das frases mais famosas de Sócrates é: "todo mundo é burro menos eu". Além disso, Sócrates se levava extremamente a sério, sendo a primeira pessoa a crinjar toda a Grécia. Isso fez muitos comediantes da época criarem peças para caçoarem de Sócrates. Provavelmente, a pessoa que mais fez piada com Sócrates foi o comediante Aristófanes. Em sua peça "As Nuvens", Aristófanes descreveu Sócrates como um filósofo muito sério, que seus discípulos tocavam trombetas sempre que ele chegava em algum lugar e que ele falava como o Leandro Karnal. Apesar disso, Aristófanes escreveu que uma das maiores descobertas de Sócrates foi a de que o mosquito zumbia pela bunda — ou seja, além de filósofo, era biólogo. Para Sócrates, o que as pessoas comuns dizem é apenas parcialmente verdadeiro, assim como essa pequena biografia.
',
             'url' => 'https://youtu.be/AxLlcmWBKR8'
         ]);

         $video2 = Video::create([
             'title' => 'playlist para estudar como um filósofo do século XVII',
             'description' => '**Se quer mais conteúdo como esse, dê uma CURTIDA nesse vídeo e clique em INSCREVER-SE!** Playlist para estudar como um fiósofo do século XVII.
',
             'url' => 'https://youtu.be/_KGNtPp67Z4'
         ]);

         $video3 = Video::create([
             'title' => 'playlist para estudar como nietzsche sobre o abismo em uma corda bamba entre o animal e o übermensch',
             'description' => '**Cada curtida é um passo para o übermensch.** Capa: Frame do filme "Dias de Nietzsche em Turim"',
             'url' => 'https://youtu.be/80084Zqs-Fo'
         ]);

         return collect([$video1, $video2, $video3]);
    }
}

if(! function_exists('create_sample_users')) {
    function create_sample_users()
    {
        $user1 = User::create([
            'name' => 'Pakistani Danny',
            'email' => 'pakistanidanny@casteaching.com',
            'password' => 'contrasenyaanticopiadeltreball'
        ]);

        $user2 = User::create([
            'name' => 'Pedro',
            'email' => 'pedro@casteaching.com',
            'password' => 'contrasenyaanticopiadeltreball'
        ]);

        $user3 = User::create([
            'name' => 'Munia',
            'email' => 'munia@casteaching.com',
            'password' => 'contrasenyaanticopiadeltreball'
        ]);

        return collect([$user1, $user2, $user3]);
    }
}

class DomainObject implements ArrayAccess, JsonSerializable
{
    private $data = [];

    /**
     * DomainObject constructor.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function __get($name)
    {
        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->data);
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function __toString()
    {
        return (string) collect($this->data);
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return $this->data;
    }
}

if(! function_exists('objectify')) {
    function objectify($array)
    {
        return new DomainObject($array);
    }
}
