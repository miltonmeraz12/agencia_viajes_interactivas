<?php

namespace App\Mail;

use App\Models\Reservacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CompraConfirmadaMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Reservacion $reservacion) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Confirmacion de compra - Folio '.$this->reservacion->folio);
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.compra-confirmada',
            with: ['reservacion' => $this->reservacion]
        );
    }
}
