<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class HODNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $HOD;
    public $auditee;
    public $number;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($HODMail,$number, $auditee)
    {
        $this->HOD = $HODMail;
        $this->auditee = $auditee;
        $this->number = $number;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.HODnotify')
        ->subject('New CAR for Review');
    }
}
