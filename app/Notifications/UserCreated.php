<?php

namespace App\Notifications;

use App\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class UserCreated extends VerifyEmail
{
    use Queueable;

//    private static $toMailCallback;
    private $password, $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($email,$password)
    {
        $this->email = $email;
        $this->password = $password;
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

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
//        return (new MailMessage)
//            ->from("info@bfs.com.na")
//            ->subject("Verify Email Address")
//            ->line("This is your username/email: ".$this->email)
//            ->line("This is your password: ". $this->password)
//            ->line("Please click the button below to verify your email address.");

        return (new MailMessage)
            ->from("info@bfs.com.na")
            ->subject("Verify Email Address")
            ->line("Please click the button below to verify your email address.")
            ->line("This is your username/email: ".$this->email)
            ->line("This is your password: ". $this->password)
            ->line("Please click the button below to verify your email address.")
            ->action("Verify Email Address", $this->verificationUrl($notifiable))
            ->line("After your email has been verified, sign in and the site will navigate you to change your password.")
            ->line("If you did not create an account, no further action is required.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
