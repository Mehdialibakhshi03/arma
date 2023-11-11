<?php

namespace App\Http\Controllers\Admin;

use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Mail\ConatctMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\MailTemplates\Models\MailTemplate;

class RequestuserController extends Controller
{
    public function contactus($lang = 'en')
    {
        \App::setLocale($lang);
        return view('contactus', compact('lang'));
    }

    public function termsandconditions($lang = 'en')
    {
        \App::setLocale($lang);
        return view('termsandconditions', compact('lang'));
    }

    public function privacypolicy($lang = 'en')
    {
        \App::setLocale($lang);
        return view('privacypolicy', compact('lang'));
    }

    public function faq($lang = 'en')
    {
        \App::setLocale($lang);
        return view('faq', compact('lang'));
    }

    public function contact_mail(Request $request)
    {
        if (UtilityFacades::getsettings('contact_us_recaptcha_status') == '1') {
            $validator = \Validator::make($request->all(), [
                'g-recaptcha-response' => 'required',
            ]);
            if ($validator->fails()) {
                $messages = $validator->errors();
                return redirect()->back()->with('errors', $messages->first());
            }
        }
        if (MailTemplate::where('mailable', ConatctMail::class)->first()) {
            try {
                if ($request) {
                    $details = $request->all();
                    Mail::to(UtilityFacades::getsettings('contact_email'))->send(new ConatctMail($request->all()));
                } else {
                    return redirect()->back()->with('failed', __('Please check Recaptch.'));
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('errors', $e->getMessage());
            }
            return redirect()->back()->with('success', 'Email sent successfully.');
        }
    }
}
