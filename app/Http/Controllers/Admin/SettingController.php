<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Setting;
use function App\Http\Controllers\dd;
use function App\Http\Controllers\public_path;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.setting.index');
    }

    public function update(SettingRequest $request)
    {
        try {
            $logo = Setting::where('key', 'logo')->pluck('value')->first();
            try{
                if ($request->has('logo')) {
                $fileNameImage = generateFileName($request->logo->getClientOriginalName());

                $request->logo->move(env('SETTING_UPLOAD_PATH'), $fileNameImage);

                $path = public_path(env('SETTING_UPLOAD_PATH') . $logo);
                unlink_image_helper_function($path);
                $logo = $fileNameImage;
            }
            }catch(\Exception $e){
                dd($e->getMessage());
            }
            $footer_logo = Setting::where('key', 'footer_logo')->pluck('value')->first();
            if ($request->has('footer_logo')) {
                $fileNameImage = generateFileName($request->footer_logo->getClientOriginalName());
                $request->footer_logo->move(env('SETTING_UPLOAD_PATH'), $fileNameImage);
                $path = public_path(env('SETTING_UPLOAD_PATH') . $footer_logo);
                unlink_image_helper_function($path);
                $footer_logo = $fileNameImage;
            }
            $fav_icon = Setting::where('key', 'fav_icon')->pluck('value')->first();
            if ($request->has('fav_icon')) {
                $fileNameImage = generateFileName($request->fav_icon->getClientOriginalName());
                $request->fav_icon->move(env('SETTING_UPLOAD_PATH'), $fileNameImage);
                $path = public_path(env('SETTING_UPLOAD_PATH') . $fav_icon);
                unlink_image_helper_function($path);
                $fav_icon = $fileNameImage;
            }
            if ($request->has('robot_index')) {
                $robot_index = 1;
            } else {
                $robot_index = 0;
            }
            $title = $request->title;
            $meta_keywords = $request->meta_keywords;
            $meta_description = $request->meta_description;
            $start_market = $request->start_market;
            $end_market = $request->end_market;
            $array = [
                'title' => $title,
                'meta_keywords' => $meta_keywords,
                'meta_description' => $meta_description,
                'robot_index' => $robot_index,
                'logo' => $logo,
                'footer_logo' => $footer_logo,
                'fav_icon' => $fav_icon,
                'start_market' => $start_market,
                'end_market' => $end_market,
            ];
            foreach ($array as $key => $item) {
                $config = Setting::where('key', $key)->first();
                $config->update([
                    'value' => $item
                ]);
            }
            $type = 'success';
            $msg = 'Settings Has Been Updated Successfully';
        } catch (\Exception $exception) {
            $type = 'failed';
            $msg = $exception->getMessage();
        }
        session()->flash($type, $msg);
        return redirect()->back();
    }
}
