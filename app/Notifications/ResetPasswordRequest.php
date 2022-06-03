<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ResetPasswordRequest extends Notification implements ShouldQueue
{
    use Queueable;
    protected $token;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $user)
    {
        $this->token = $token;
        $this->user = $user;
    }
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = 'http://localhost:3000/accounts/reset_password/' . $this->token;
        Log::channel('mail')->info("URL = $url");
        Mail::send('emails.reset_password', ['url' => $url], function ($message) {
            $message->from('quynb@kaopiz.com', 'Quynb');
            $message->to($this->user->email, $this->user->name)->subject('Reset Password');
            $message->subject('Reset Password');
        });
        
        return (new MailMessage)
            ->line('You are receiving this email because we received a password reset request for your account.')
            ->action('Reset Password', url($url))
            ->line('If you did not request a password reset, no further action is required.')
            ->line('Thank you for using our application!')
            ->line('The Laravel Team')
            ->render();
    }
}