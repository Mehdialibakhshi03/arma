<?php

namespace App\Jobs;

use App\Mail\NewUserRegisteredAdminMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewUserRegisteredForAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $email;
    public function __construct($email)
    {
       $this->email=$email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        $send_mail=$this->email;
        $email = new NewUserRegisteredAdminMail();
        Mail::to($send_mail)->send($email);
    }
}
