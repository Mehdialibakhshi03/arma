<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MailMessages;
use App\Models\Type;
use App\Models\User;
use App\Models\UserStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index($type)
    {
        $user_status = UserStatus::where('id', $type)->pluck('title')->first();
        $users = User::where('active_status', $type)->paginate(100);
        return view('admin.users.index', compact('users', 'type', 'user_status'));
    }

    public function remove(Request $request)
    {
        try {
            $item = User::findOrFail($request->id);
            $item->delete();
            $message = 'The Item Has Been Deleted Successfully';
            session()->flash('success', $message);
            $type = 1;
        } catch (\Exception $exception) {
            session()->flash('failed', $exception->getMessage());
            $type = 0;
        }
        $alert = view('admin.sections.alert')->render();
        return response()->json([$type, $alert]);
    }

    public function edit($type, User $user)
    {
        $userStatus = UserStatus::all();
        $user_status = UserStatus::where('id', $type)->pluck('title')->first();
        $messages = MailMessages::whereIn('id', [3, 4])->get();
        $userTypes = Type::all();
        return view('admin.users.edit', compact('user', 'type', 'userStatus', 'messages', 'user_status', 'userTypes'));
    }

    public function update(Request $request, $type, User $user)
    {
        try {
            $user->update($request->all());
            $user->roles()->detach();
            $user->assignRole($request->role_request_id);
            $message = 'The Item Has Been Updated Successfully';
            session()->flash('success', $message);
        } catch (\Exception $exception) {
            session()->flash('failed', $exception->getMessage());
        }
        return redirect()->back();
    }

    public function reset_password(Request $request, User $user)
    {
        $request->validate([
            'new_password' => 'required'
        ]);
        try {
            $new_password = $request->new_password;
            $user->update([
                'password' => Hash::make($new_password)
            ]);
            $message = 'New Password Generated Successfully';
            session()->flash('success', $message);
        } catch (\Exception $exception) {
            session()->flash('failed', $exception->getMessage());
        }
        return redirect()->back();
    }
}
