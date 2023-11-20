<?php

namespace App\Providers;

use App\Models\Header1;
use App\Models\Header2;
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
                'top_bar_color'
            ));
    }
}
