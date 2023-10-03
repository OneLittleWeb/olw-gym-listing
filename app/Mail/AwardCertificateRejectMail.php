<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AwardCertificateRejectMail extends Mailable
{
    use Queueable, SerializesModels;

    public $award_certificate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($award_certificate)
    {
        $this->award_certificate = $award_certificate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(env('APP_NAME') . ' award certificate - ' . $this->award_certificate->organization['organization_name'])
            ->view('email.award.rejected_award_certificate');
    }
}
