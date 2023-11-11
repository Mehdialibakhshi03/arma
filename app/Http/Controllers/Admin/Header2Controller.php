<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Header2Request;
use App\Models\Header2;

class Header2Controller extends Controller
{
    public function index()
    {
        $items = Header2::latest()->paginate(20);
        return view('admin.header2.index', compact('items'));
    }

    public function create()
    {
        $view =  view('admin.header2.create');
        return ['html' => $view->render()];
    }


    public function store(Header2Request $request)
    {
        try {
            Header2::create($request->all());
            $type = 'success';
            $msg = 'The Item Has Been Created Successfully';

        } catch (\Exception $exception) {
            $type = 'failed';
            $msg = $exception->getMessage();
        }
        session()->flash($type, $msg);
        return redirect()->route('admin.header2.index');
    }

    public function edit($id)
    {
        $item =  Header2::where('id',$id)->first();
        $view =  view('admin.header2.edit',compact('item'));
        return ['html' => $view->render()];
    }

    public function update(Header2Request $request, $id)
    {
        $item =  Header2::where('id',$id)->first();
        $item->update($request->all());
        return redirect()->route('admin.header2.index')
            ->with('success',  __('Header 2 updated successfully.'));
    }

    public function remove($id)
    {
        try {
            $item = Header2::findOrFail($id);

            $item->delete();
            $message = 'The Item Has Been Deleted Successfully';

            return redirect()->back()->with('success', __($message));
        } catch (\Exception $exception) {

            return redirect()->back()->with('failed', __($exception->getMessage()));
        }


    }
}
