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
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        if (Redis::exists($token)){
            $this->token = Redis::get($token);
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
                'name' => $this->token->name,
                'email' => $this->token->email,
                'url' => '127.0.0.1:8080/#/success/'.$this->token->token,
            ]);
    }
}
