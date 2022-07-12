<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($otp,$user)
    {
        $this->otp = $otp;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name').' - Email Verification')  
        ->with(['otp' => $this->otp, 'user' => $this->user])          
        ->view('email.verification');
    }
}
