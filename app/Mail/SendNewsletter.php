<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    public $new_user;
    public $user_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_name, bool $new_user,$title,$description)
    {
        $this->new_user = $new_user;
        $this->user_name = $user_name;
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if($this->new_user){
            return $this->markdown('emails.newsletters.newUser')
            ->subject('Thank you for subscribing')
            ->with([
                'user_name' => $this->user_name,
                'title' => $this->title,
                'description' => $this->description
            ]);
        } else {
            return $this->markdown('emails.newsletters.oldUser')
            ->subject('Newsletter')
            ->with([
                'user_name' => $this->user_name,
                'title' => $this->title,
                'description' => $this->description
            ]);
        }
    }   
}
