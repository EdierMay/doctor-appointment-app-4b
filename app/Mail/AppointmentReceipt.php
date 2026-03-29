<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment; // Asegúrate de que esta línea esté

class AppointmentReceipt extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $pdfData;

    /**
     * Create a new message instance.
     */
    public function __construct($appointment, $pdfData)
    {
        $this->appointment = $appointment;
        $this->pdfData = $pdfData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu Comprobante de Cita Médica',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'welcome', // Usamos la vista de bienvenida por defecto como cuerpo del correo
        );
    }

    /**
     * Get the attachments for the message.
     */
    public function attachments(): array
    {
        // Aquí adjuntamos el PDF que generamos en el controlador
        return [
            Attachment::fromData(fn () => $this->pdfData, 'Comprobante_Cita.pdf')
                ->withMime('application/pdf'),
        ];
    }
}