<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\FormValuesDataTable;
use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Mail\FormSubmitEmail;
use App\Mail\Thanksmail;
use App\Models\Form;
use App\Models\FormValue;
use App\Models\Market;
use App\Models\MarketSetting;
use App\Models\User;
use App\Models\UserStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class MarketController extends Controller
{
    public function index()
    {
        $markets = Market::orderBy('start', 'desc')->paginate(100);
        return view('admin.markets.index', compact('markets'));
    }

    public function edit(Market $market)
    {
        return view('admin.markets.edit', compact('market'));
    }

    public function bids(Market $market)
    {
        $bids = $market->Bids;
        return view('admin.markets.bids', compact('market', 'bids'));
    }

    public function update(Market $market, Request $request)
    {
        $request->validate([
            'start' => 'required|date',
            'min_price' => 'required|numeric',
            'min_wallet' => 'required|numeric',
            'min_quantity' => 'required|numeric',
        ]);
        $request['status'] = 7;
        if (Carbon::now() < $request->start) {
            $request['status'] = 1;
        }
        $market->update($request->all());
        return redirect()->route('admin.markets.index')->with('success', 'Market updated successfully');
    }

    public function setting_index()
    {
        $ready_to_duration = MarketSetting::where('key', 'ready_to_duration')->first()->value;
        $open_duration = MarketSetting::where('key', 'open_duration')->first()->value;
        $q_1 = MarketSetting::where('key', 'q_1')->first()->value;
        $q_2 = MarketSetting::where('key', 'q_2')->first()->value;
        $q_3 = MarketSetting::where('key', 'q_3')->first()->value;
        return view('admin.markets.settings', compact('ready_to_duration', 'open_duration', 'q_1', 'q_2', 'q_3'));
    }

    public function setting_update(Request $request)
    {
        $request->validate([
            'ready_to_duration' => 'required',
            'open_duration' => 'required',
            'q_1' => 'required',
            'q_2' => 'required',
            'q_3' => 'required',
        ]);
        $array = [
            'ready_to_duration' => $request->ready_to_duration,
            'open_duration' => $request->open_duration,
            'q_1' => $request->q_1,
            'q_2' => $request->q_2,
            'q_3' => $request->q_3,
        ];
        foreach ($array as $key => $value) {
            MarketSetting::where('key', $key)->update(['value' => $value]);
        }
        return redirect()->route('admin.market.setting.index')->with('success', 'Settings updated successfully');
    }

    public function form_edit(Market $market)
    {
        $form_value = FormValue::find($market->form_value_id);
        $form = $form_value->Form;
        $array = json_decode($market->json);
        return view('admin.markets.fill', compact('array', 'form', 'form_value', 'market'));
    }

    public function form_update(Request $request, Market $market)
    {
        $form_value_id = $market->form_value_id;
        $form_value = FormValue::where('id', $form_value_id)->first();
        $form = $form_value->Form;
        $array = json_decode($market->json);
        foreach ($array as &$rows) {
            foreach ($rows as &$row) {
                // dd($row->type);
                if ($row->type == 'checkbox-group') {
                    foreach ($row->values as &$value) {
                        if (is_array($request->{$row->name}) && in_array($value->value, $request->{$row->name})) {
                            $value->selected = 1;
                        } else {
                            if (isset($value->selected)) {
                                unset($value->selected);
                            }
                        }
                    }
                } elseif ($row->type == 'file') {
                    if ($row->subtype == "fineuploader") {
                        $file_size = number_format($row->max_file_size_mb / 1073742848, 2);
                        $file_limit = $row->max_file_size_mb / 1024;
                        if ($file_size < $file_limit) {
                            $values = [];
                            $value = explode(',', $request->input($row->name));
                            foreach ($value as $file) {
                                $values[] = $file;
                            }
                            $row->value = $values;
                        } else {
                            return response()->json(['is_success' => false, 'message' => __("Please upload maximum $row->max_file_size_mb MB file size.")], 200);
                        }
                    } else {
                        if ($row->file_extention == 'pdf') {
                            $allowedfileExtension = ['pdf'];
                        } elseif ($row->file_extention == 'excel') {
                            $allowedfileExtension = ['csv', 'xlsx'];
                        } else {
                            $allowedfileExtension = ['jpg', 'jpeg', 'png'];
                        }
                        $requiredextention = implode(',', $allowedfileExtension);
                        $file_size = number_format($row->max_file_size_mb / 1073742848, 2);
                        $file_limit = $row->max_file_size_mb / 1024;
                        if ($file_size < $file_limit) {
                            if ($row->multiple) {
                                if ($request->hasFile($row->name)) {
                                    $values = [];
                                    $files = $request->file($row->name);
                                    foreach ($files as $file) {
                                        $extension = $file->getClientOriginalExtension();
                                        $check = in_array($extension, $allowedfileExtension);
                                        if ($check) {
                                            if ($extension == 'csv') {
                                                $name = \Str::random(40) . '.' . $extension;
                                                $file->move(storage_path() . '/app/form_values/' . $form->id, $name);
                                                $values[] = 'form_values/' . $form->id . '/' . $name;
                                            } else {
                                                // $filename = $file->store('form_values/' . $form->id);
                                                // $values[] = $filename;
                                                // $filename = $file->store('form_values/' . $form->id);
                                                $path = Storage::path("form_values/$form->id");
                                                $filename = $file->store('form_values/' . $form->id);
                                                $newpath = Storage::path($filename);
                                                chmod("$path", 0777);
                                                chmod("$newpath", 0777);
                                                $values[] = $filename;
                                            }
                                        } else {
                                            if (isset($request->ajax)) {
                                                return response()->json(['is_success' => false, 'message' => __("Invalid file type, Please upload $requiredextention files")], 200);
                                            } else {
                                                return redirect()->back()->with('failed', __("Invalid file type, please upload $requiredextention files."));
                                            }
                                        }
                                    }
                                    $row->value = $values;
                                }
                            } else {
                                if ($request->hasFile($row->name)) {
                                    $values = '';
                                    $file = $request->file($row->name);
                                    $extension = $file->getClientOriginalExtension();
                                    $check = in_array($extension, $allowedfileExtension);
                                    if ($check) {
                                        if ($extension == 'csv') {
                                            $name = \Str::random(40) . '.' . $extension;
                                            $file->move(storage_path() . '/app/form_values/' . $form->id, $name);
                                            $values = 'form_values/' . $form->id . '/' . $name;
                                            chmod("$values", 0777);
                                        } else {
                                            // $filename = $file->store('form_values/' . $form->id);
                                            // $values = $filename;
                                            // $filename = $file->store('form_values/' . $form->id);
                                            $path = Storage::path("form_values/$form->id");
                                            $filename = $file->store('form_values/' . $form->id);
                                            $newpath = Storage::path($filename);
                                            chmod("$path", 0777);
                                            chmod("$newpath", 0777);
                                            $values = $filename;
                                        }
                                    } else {
                                        if (isset($request->ajax)) {
                                            return response()->json(['is_success' => false, 'message' => __("Invalid file type, Please upload $requiredextention files")], 200);
                                        } else {
                                            return redirect()->back()->with('failed', __("Invalid file type, please upload $requiredextention files."));
                                        }
                                    }
                                    $row->value = $values;
                                }
                            }
                        } else {
                            return response()->json(['is_success' => false, 'message' => __("Please upload maximum $row->max_file_size_mb MB file size.")], 200);
                        }
                    }
                } elseif ($row->type == 'radio-group') {
                    foreach ($row->values as &$value) {
                        if ($value->value == $request->{$row->name}) {
                            $value->selected = 1;
                        } else {
                            if (isset($value->selected)) {
                                unset($value->selected);
                            }
                        }
                    }
                } elseif ($row->type == 'autocomplete') {
                    if (isset($row->multiple)) {
                        foreach ($row->values as &$value) {
                            if (is_array($request->{$row->name}) && in_array($value->value, $request->{$row->name})) {
                                $value->selected = 1;
                            } else {
                                if (isset($value->selected)) {
                                    unset($value->selected);
                                }
                            }
                        }
                    } else {
                        foreach ($row->values as &$value) {
                            if ($value->value == $request->{$row->name}) {
                                $value->selected = 1;
                            } else {
                                if (isset($value->selected)) {
                                    unset($value->selected);
                                }
                            }
                        }
                    }
                } elseif ($row->type == 'select') {
                    if (isset($row->multiple) & !empty($row->multiple)) {
                        foreach ($row->values as &$value) {
                            if (is_array($request->{$row->name}) && in_array($value->value, $request->{$row->name})) {
                                $value->selected = 1;
                            } else {
                                if (isset($value->selected)) {
                                    unset($value->selected);
                                }
                            }
                        }
                    } else {
                        foreach ($row->values as &$value) {
                            if ($value->value == $request->{$row->name}) {
                                $value->selected = 1;
                            } else {
                                if (isset($value->selected)) {
                                    unset($value->selected);
                                }
                            }
                        }
                    }
                } elseif ($row->type == 'date') {
                    $row->value = $request->{$row->name};
                } elseif ($row->type == 'number') {
                    $row->value = $request->{$row->name};
                } elseif ($row->type == 'textarea') {
                    $row->value = $request->{$row->name};
                } elseif ($row->type == 'text') {
                    $client_email = '';
                    if ($row->subtype == 'email') {
                        if (isset($row->is_client_email) && $row->is_client_email) {

                            $client_emails[] = $request->{$row->name};
                        }
                    }
                    $row->value = $request->{$row->name};
                } elseif ($row->type == 'starRating') {
                    $row->value = $request->{$row->name};
                } elseif ($row->type == 'SignaturePad') {
                    if (property_exists($row, 'value')) {
                        $filepath = $row->value;
                        if ($request->{$row->name} == '') {
                            $url = $row->value;
                        } else {
                            $url = $request->{$row->name};
                            $imageContent = file_get_contents($url);
                            $filePath = Storage::path($filepath);
                            $file = file_put_contents($filePath, $imageContent);
                        }

                        $row->value = $filepath;
                    } else {
                        if (!file_exists(Storage::path("form_values/$form->id"))) {
                            mkdir(Storage::path("form_values/$form->id"), 0777, true);
                            chmod(Storage::path("form_values/$form->id"), 0777);
                        }
                        $filepath = "form_values/$form->id/" . rand(1, 1000) . '.png';
                        $url = $request->{$row->name};
                        $imageContent = file_get_contents($url);
                        $filePath = Storage::path($filepath);
                        $file = file_put_contents($filePath, $imageContent);
                        $row->value = $filepath;
                    }
                } elseif ($row->type == 'location') {
                    foreach ($request->{$row->name} as $value) {
                        $row->value = [
                            'lat' => $value['latitude'],
                            'lng' => $value['longitude'],
                        ];
                    }
                }
            }
        }
        $market->json = json_encode($array);
        $market->save();
        $route = route('admin.markets.index');
        $success_msg = 'updated successfully';
        return response()->json(['is_success' => true, 'message' => __($success_msg), 'redirect' => $route], 200);
    }
}
