<?php

namespace App\Mail;

use App\Models\Reservacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReservacionCanceladaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Reservacion $reservacion) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Reservacion cancelada - Folio '.$this->reservacion->folio);
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.reservacion-cancelada',
            with: ['reservacion' => $this->reservacion]
        );
    }
}
