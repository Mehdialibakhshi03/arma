<?php

namespace App\Jobs;

use App\Mail\CustomMessageToUserMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CustomMessageToUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $message;
    public $title;
    public $user_mail;
    public $email;
    public function __construct($message,$title,$user_mail,$email)
    {
        $this->title=$title;
        $this->message=$message;
        $this->user_mail=$user_mail;
        $this->email=$email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $send_mail=$this->email;
        $email = new CustomMessageToUserMail($this->message,$this->title,$this->user_mail);
        Mail::to($send_mail)->send($email);
    }
}
