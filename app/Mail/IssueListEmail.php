<?php

namespace App\Mail;

use App\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Spatie\MediaLibrary\Models\Media;

class IssueListEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Email $email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this
            ->subject($this->email->subject)
            ->markdown('emails.issuelistemail', ['body' => $this->email->body]);

        /** @var Media $media */
        foreach ($this->email->getMedia('attachments') as $media) {
            $this->attach($media->getPath());
        }
        return $this;
    }
}
