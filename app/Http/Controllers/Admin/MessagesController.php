<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MailMessages;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function emails()
    {
        $emails = MailMessages::paginate(50);
        return view('admin.messages.mails.index', compact('emails'));
    }

    public function email_edit($id)
    {
        $mail = MailMessages::where('id',$id)->first();

        return  view('admin.messages.mails.edit', compact('mail'));

    }

    public function email_update(Request $request,$id)
    {
        $mail = MailMessages::where('id',$id)->first();
        $mail->update($request->all());
        return redirect()->route('admin.emails.index')
            ->with('success',  __('mail updated successfully.'));
    }

    public function alerts()
    {
        $alerts = Message::paginate(50);
        return view('admin.messages.alerts.index', compact('alerts'));
    }

    public function alert_edit($id)
    {
        $alert = Message::where('id',$id)->first();
        return view('admin.messages.alerts.edit', compact('alert'));
    }

    public function alert_update(Request $request,$id)
    {

            $alert = Message::where('id',$id)->first();
            $alert->update($request->all());
        return redirect()->route('admin.alerts.index')
            ->with('success',  __('The Item Has Been Updated Successfully.'));
    }
}
