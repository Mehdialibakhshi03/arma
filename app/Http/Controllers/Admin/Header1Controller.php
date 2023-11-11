<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Header1Request;
use App\Models\Header1;

class Header1Controller extends Controller
{
    public function index()
    {
        $items = Header1::latest()->paginate(20);
        return view('admin.header1.index', compact('items'));
    }

    public function create()
    {
        $view =  view('admin.header1.create');
        return ['html' => $view->render()];
    }

    public function store(Header1Request $request)
    {
        try {
            Header1::create($request->all());
            $type = 'success';
            $msg = 'The Item Has Been Created Successfully';

        } catch (\Exception $exception) {
            $type = 'failed';
            $msg = $exception->getMessage();
        }
        session()->flash($type, $msg);
        return redirect()->route('admin.header1.index');
    }

    public function edit($id)
    {
        $item =  Header1::where('id',$id)->first();
        $view =  view('admin.header1.edit',compact('item'));
        return ['html' => $view->render()];
    }

    public function update(Header1Request $request, $id)
    {
        $item =  Header1::where('id',$id)->first();
            $item->update($request->all());
        return redirect()->route('admin.header1.index')
            ->with('success',  __('Header 1 updated successfully.'));
    }

    public function remove($id)
    {
        try {
            $item = Header1::findOrFail($id);

            $item->delete();
            $message = 'The Item Has Been Deleted Successfully';

            return redirect()->back()->with('success', __($message));
        } catch (\Exception $exception) {

            return redirect()->back()->with('failed', __($exception->getMessage()));
        }


    }
}
