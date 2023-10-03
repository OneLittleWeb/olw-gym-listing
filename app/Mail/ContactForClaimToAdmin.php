<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactForClaimToAdmin extends Mailable
{
    use Queueable, SerializesModels;

    public $organization;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($organization)
    {
        $this->organization = $organization;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Contact for business profile' . ' - ' . $this->organization['organization_name'])
            ->view('email.claim.contact.contact-for-claim-to-admin');
    }
}
