<?php

namespace App\Notifications;

use Ichtrojan\Otp\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
//use \Ichtrojan\Otp\Models\Otp;
use APP\Models\User;

class EmailVerficationNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

     public $message; 
     public $subject;
     public $fromEmail; 
     public $mailer;
     private $otp;
    public function __construct()
    {
        $this->message = "use the blow code for Email verification"; 
        $this->subject = " verification needed"; 
        $this->fromEmail = "hello@example.com";
        $this->mailer = "smtp";
        $this->otp = new Otp;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $otp = $this->otp->generate($notifiable->email,6,60);
        return (new MailMessage)
        ->mailer('smtp')
        ->subject($this->subject)
        ->greeting("hello"." ".$notifiable->name)
        ->line($this->message)
        ->line("code"." ".$otp->token);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
