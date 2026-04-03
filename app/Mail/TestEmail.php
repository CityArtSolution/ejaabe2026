<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $senderEmail;
    public $senderName;
    public $subject;
    public $message;

    public function __construct($data)
    {
        $this->senderEmail = $data['email'] ?? '';
        $this->senderName = $data['name'] ?? '';
        $this->subject = $data['subject'] ?? ''; // Ensure this is a string
        $this->message = $data['message'] ?? ''; // Ensure this is a string
    }

    public function build()
    {
        return $this->from('growthwavesa25@gmail.com')
                    ->replyTo($this->senderEmail, $this->senderName)
                    ->subject("Contact Form: {$this->subject}")
                    ->view('web.default.emails.notification')
                    ->with([
                        'subject' => $this->subject, // Pass subject to the view
                        'message' => $this->message, // Pass message to the view
                    ]);
    }
}