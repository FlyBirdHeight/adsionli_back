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
    public $token;
    public $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token,$name)
    {
        if (Redis::exists($token)){
            $this->token = $token;
            $this->name = $name;
        }
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
                'url' => '127.0.0.1:8080/#/success/'.$this->token,
            ]);
    }
}
