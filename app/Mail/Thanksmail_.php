<?php

namespace App\Mail;

use App\Models\FormValue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Thanksmail_ extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(FormValue $form_value)
    {
        $this->form_value = $form_value;
    }

    public function build()
    {
        return $this->markdown('emails.thanks_form_submit')->with('form_value',$this->form_value)->subject('New survey Submited - '. $this->form_value->Form->title);

    }
}
