<?php

namespace App\Mail;

use App\Models\Aspiration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AspirationStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $aspiration;

    /**
     * Create a new message instance.
     */
    public function __construct(Aspiration $aspiration)
    {
        $this->aspiration = $aspiration;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Status Aspirasi Anda Telah Diupdate')
                    ->view('emails.aspiration_status');
    }
}
