<?php

namespace App\Providers;

use App\Models\Header1;
use App\Models\Header2;
use App\Models\MarketSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Modules\Setting\app\Models\Setting;


class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        Paginator::useBootstrap();
        $header1 = Header1::OrderBy('priority', 'asc')->get();
        $header2 = Header2::orderBy('priority', 'asc')->get();
        $logo = Setting::where('key', 'logo')->pluck('value')->first();
        $fav_icon = Setting::where('key', 'fav_icon')->pluck('value')->first();
        $title = Setting::where('key', 'title')->pluck('value')->first();
        $meta_keywords = Setting::where('key', 'meta_keywords')->pluck('value')->first();
        $robot_index = Setting::where('key', 'robot_index')->pluck('value')->first();
        $meta_description = Setting::where('key', 'meta_description')->pluck('value')->first();
        $footer_logo = Setting::where('key', 'footer_logo')->pluck('value')->first();
        $start_market = Setting::where('key', 'start_market')->pluck('value')->first();
        $end_market = Setting::where('key', 'end_market')->pluck('value')->first();
        $admin_avatar = Setting::where('key', 'admin_avatar')->pluck('value')->first();
        $side_bar_color = Setting::where('key', 'side_bar_color')->pluck('value')->first();
        $top_bar_color = Setting::where('key', 'top_bar_color')->pluck('value')->first();
        $alert_description =Setting::where('key', 'alert_description')->pluck('value')->first();
        $alert_bg_color = Setting::where('key', 'alert_bg_color')->pluck('value')->first();
        $alert_text_color =Setting::where('key', 'alert_text_color')->pluck('value')->first();
        $alert_font_size =Setting::where('key', 'alert_font_size')->pluck('value')->first();
        $alert_height = Setting::where('key', 'alert_height')->pluck('value')->first();
        $alert_active=Setting::where('key', 'alert_active')->pluck('value')->first();
        $ready_to_duration=MarketSetting::where('key','ready_to_duration')->pluck('value')->first();
        $open_duration=MarketSetting::where('key','open_duration')->pluck('value')->first();
        $q_1=MarketSetting::where('key','q_1')->pluck('value')->first();
        $q_2=MarketSetting::where('key','q_2')->pluck('value')->first();
        $q_3=MarketSetting::where('key','q_3')->pluck('value')->first();
        view()->share(
            compact(
                'header1',
                'header2',
                'logo',
                'footer_logo',
                'fav_icon',
                'title',
                'meta_keywords',
                'robot_index',
                'meta_description',
                'start_market',
                'admin_avatar',
                'end_market',
                'side_bar_color',
                'top_bar_color',
                'alert_description',
                'alert_bg_color',
                'alert_text_color',
                'alert_font_size',
                'alert_height',
                'alert_active',
                'ready_to_duration',
                'open_duration',
                'q_1',
                'q_2',
                'q_3'
            ));
    }
}
