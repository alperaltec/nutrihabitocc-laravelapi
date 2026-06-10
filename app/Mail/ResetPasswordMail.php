<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $user;
    public $code;
    public function __construct(User $user, string $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Código de Recuperación de Contraseña',
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: "
            <div style='font-family: sans-serif; color: #333; max-width: 600px; margin: auto;'>
                <h2 style='color: #2d3748;'>Recuperación de Contraseña</h2>
                <p>Hola <strong>{$this->user->name} {$this->user->last_name}</strong>,</p>
                <p>Has solicitado restablecer tu contraseña. Utiliza el siguiente código para continuar con el proceso:</p>

                <div style='background-color: #f7fafc; padding: 20px; text-align: center; border-radius: 8px; margin: 20px 0;'>
                    <span style='font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #4a5568;'>
                        {$this->code}
                    </span>
                </div>

                <p style='color: #e53e3e; font-size: 0.9em;'>Este código expirará en 10 minutos.</p>

                <br>
                <hr style='border: 0; border-top: 1px solid #edf2f7;'>
                <p style='font-size: 0.8em; color: #718096; text-align: center;'>
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
