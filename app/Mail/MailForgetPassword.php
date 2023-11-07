<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailForgetPassword extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
    }

    /**
     * Get the message envelope.
     */
    public function build(): self
    {
        return $this->view('pages.clients.mail.forgetPassword')
            ->subject('Mail Reset Password');
    }
}
