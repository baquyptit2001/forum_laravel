<?php

namespace App\Jobs;

use App\Notifications\ResetPasswordRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class ForgotPasswordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $user;
    protected $token;

    public function __construct($user, $token)
    {
        $url = 'http://localhost:3000/accounts/reset_password/' . $token;
        Log::channel('mail')->info("URL = $url");
        Mail::send('emails.reset-password', ['url' => $url], function ($message) use ($user) {
            $message->from('quynb@kaopiz.com', 'Quynb');
            $message->to($user->email, $user->name)->subject('Reset Password');
            $message->subject('Reset Password');
        });
//        $user->notify(new ResetPasswordRequest($token, $user));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
    }
}
