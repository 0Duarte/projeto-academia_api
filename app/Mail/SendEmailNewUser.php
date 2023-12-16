<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmailNewUser extends Mailable
{
    use Queueable, SerializesModels;

    public $NewUser;
    public function __construct($user)
    {
        $this->NewUser = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Seja bem vindo à GymPro',
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'mails.MailWelcomeUser',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
