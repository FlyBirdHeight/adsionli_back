<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class RegisterMail extends Mailable
{
    use Queueable, SerializesModels;
    public $url;
    public $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($url,$name)
    {
        $this->url= $url;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail')
            ->with([
                'name' => $this->name,
                'url' => $this->url,
            ]);
    }
}
