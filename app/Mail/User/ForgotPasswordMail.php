<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $user;
    protected $password;

    /**
     * Create a new message instance.
     * @param object $user \App\User
     * @param string $password
     * @return void
     */
    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data['password'] = $this->password;
        $data['user'] = $this->user;

        return $this->markdown('mail/user/forgot-password', $data);
    }
}
