<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AwsEmail extends Mailable
{
    use Queueable, SerializesModels;
	public $emailData;
	public $subjectAndView;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emailData=null,$subjectAndView=null)
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

        return $this->from('dk6418460@gmail.com')->subject($this->subjectAndView['subject'])->markdown($this->subjectAndView['view']);
    }
}
