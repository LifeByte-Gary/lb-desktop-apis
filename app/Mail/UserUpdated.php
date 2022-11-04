<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserUpdated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The user's old attributes.
     *
     * @var array
     */
    public array $attributes;


    /**
     * The update request payload.
     *
     * @var array
     */
    public array $payload;

    /**
     * Create a new message instance.
     *
     * @param array $attributes
     * @param array $payload
     */
    public function __construct(array $attributes, array $payload)
    {
        $this->attributes = $attributes;
        $this->payload = $payload;
    }

    /**
     * Get the message envelope.
     *
     * @return Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'User Updated',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return Content
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.users.updated',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
