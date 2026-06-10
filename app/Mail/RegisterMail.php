<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegisterMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Bienvenido(a) ' . $this->user->name . '!',
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: "
            <div style='font-family: sans-serif; color: #333;'>
                <h1 style='color: #2d3748;'>¡Bienvenido a nuestra plataforma!</h1>
                <p>Hola <strong>{$this->user->name} {$this->user->last_name}</strong>,</p>
                <p>Tu cuenta ha sido creada exitosamente. Estamos felices de tenerte con nosotros.</p>
                <br>
                <p style='font-size: 0.8em; color: #718096;'>
                    Este es un correo automático, por favor no respondas a este mensaje.<br>
                    © 2026 Universal World Technology EC. Guayaquil, Ecuador.
                </p>
            </div>
        ",
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
