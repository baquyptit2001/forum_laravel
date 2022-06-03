<?php

namespace App\Jobs;

use Aloha\Twilio\Twilio;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Twilio\Rest\Api\V2010\Account\MessageInstance;

class MessageTokenJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return MessageInstance
     */
    public function __construct($user, $token)
    {
        $twilio = new Twilio(env('TWILIO_ACCOUNT_SID'), env('TWILIO_AUTH_TOKEN'), env('SMS_NUMBER'));
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
