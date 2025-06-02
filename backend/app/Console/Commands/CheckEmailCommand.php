<?php

namespace App\Console\Commands;

use App\Mail\ScaleNotificationMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkSendEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $email = config('notification.test_email_for_check');
        $res = Mail::send(new ScaleNotificationMail("test test", $email));
        dump($res);
        return Command::SUCCESS;
    }
}
