<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = config('mail.from.address');
        $name = config('mail.from.name');
        $subject = "Verify Email";
        if ($this->user->name || $this->user->password) {
            $user_type = "admin";
        } else {
            $user_type = "customer";
        }
        return $this->view('emails.verifyUser', ['user' => $this->user, 'token' => $this->token, 'user_type' => $user_type])
            ->from($address, $name)
            ->subject($subject);
    }
}
