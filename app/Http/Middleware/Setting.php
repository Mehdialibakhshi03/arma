<?php

namespace App\Http\Middleware;

use App\Facades\UtilityFacades;
use Closure;
use Illuminate\Http\Request;

class Setting
{
    public function handle(Request $request, Closure $next)
    {
        config([
            'services.google.client_id' => UtilityFacades::getsettings('google_client_id', ''),
            'services.google.client_secret' => UtilityFacades::getsettings('google_client_secret', ''),
            'services.google.redirect' => UtilityFacades::getsettings('google_redirect', ''),

            'services.facebook.client_id' => UtilityFacades::getsettings('facebook_client_id', ''),
            'services.facebook.client_secret' => UtilityFacades::getsettings('facebook_client_secret', ''),
            'services.facebook.redirect' => UtilityFacades::getsettings('facebook_redirect', ''),

            'services.github.client_id' => UtilityFacades::getsettings('github_client_id', ''),
            'services.github.client_secret' => UtilityFacades::getsettings('github_client_secret', ''),
            'services.github.redirect' => UtilityFacades::getsettings('github_redirect', ''),

            'services.linkedin.client_id' => UtilityFacades::getsettings('linkedin_client_id', ''),
            'services.linkedin.client_secret' => UtilityFacades::getsettings('linkedin_client_secret', ''),
            'services.linkedin.redirect' => UtilityFacades::getsettings('linkedin_redirect', ''),

            'services.paytm.env' => UtilityFacades::getsettings('paytm_environment', ''),
            'services.paytm.merchant_id' => UtilityFacades::getsettings('paytm_merchant_id', ''),
            'services.paytm.merchant_key' => UtilityFacades::getsettings('paytm_merchant_key', ''),
            'services.paytm.merchant_website' => UtilityFacades::getsettings('paytm_merchant_website', ''),
            'services.paytm.channel' => UtilityFacades::getsettings('paytm_channel', ''),
            'services.paytm.industry_type' => UtilityFacades::getsettings('paytm_indistry_type', ''),

            'paypal.mode' => UtilityFacades::getsettings('paypal_mode'),
            'paypal.sandbox.client_id' => UtilityFacades::getsettings('paypal_sandbox_client_id'),
            'paypal.sandbox.client_secret' => UtilityFacades::getsettings('paypal_sandbox_client_secret'),
            'paypal.sandbox.app_id' => 'APP-80W284485P519543T',

        ]);
        return $next($request);
    }
}
