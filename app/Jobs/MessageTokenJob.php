<?php

namespace App\Jobs;

use Aloha\Twilio\Twilio;
use App\Notifications\SendPhoneToken;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageTokenJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        $twilio = new Twilio('ACf82cd86fa61a2616d201f163da22d885', 'cc215509502cbd91a8cf6fe10de3aae1', '+16067211796');
        return $twilio->message($user->phone, 'Your verification code is '.$token);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
    }
}
