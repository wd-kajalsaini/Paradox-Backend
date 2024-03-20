<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Forgot extends Mailable
{
    use Queueable, SerializesModels;

    public $emailData;
    public $subjectAndView;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailData = null, $subjectAndView = null)
    {
        $this->emailData = $emailData;
        $this->subjectAndView = $subjectAndView;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subjectAndView['subject'])->view($this->subjectAndView['view'])->with($this->emailData);
    }
}
