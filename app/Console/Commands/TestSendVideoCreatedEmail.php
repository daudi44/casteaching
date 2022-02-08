<?php

namespace App\Console\Commands;

use App\Notifications\VideoCreated;
use Illuminate\Console\Command;
use Illuminate\Notifications\Notification;

class TestSendVideoCreatedEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:videocreatednotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command example';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Notification::route('mail','daudi@iesebre.com')->notify(new VideoCreated(create_sample_video()));
    }
}
