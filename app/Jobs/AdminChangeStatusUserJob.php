<?php

namespace App\Jobs;

use App\Mail\AdminChangeStatusUserMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AdminChangeStatusUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $user;
    protected $title;
    protected $text;
    protected $note;
    protected $user_mail;
    public function __construct($user,$title,$text,$note,$user_mail)
    {
        $this->user=$user;
        $this->title=$title;
        $this->text=$text;
        $this->note=$note;
        $this->user_mail=$user_mail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $send_mail=$this->user->email;
        $email = new AdminChangeStatusUserMail($this->user,$this->title,$this->text,$this->note,$this->user_mail);
        Mail::to($send_mail)->send($email);
    }
}
