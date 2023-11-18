<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendNewUserRegisteredForAdminJob;
use App\Jobs\SendNewUserRegisteredForUserJob;
use App\Mail\NewUserRegisteredAdminMail;
use App\Models\Setting;
use App\Models\Type;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\EmailValidate;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    public function showRegistrationForm()
    {
        $types = Type::where('id','!=',1)->get();
        return view('auth.register', compact('types'));

    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));
        session()->put('UserRegistered','oooo');
        //send email with job
        $admin = Setting::where('key', 'email')->pluck('value')->first();
        dispatch(new SendNewUserRegisteredForAdminJob($admin));
        dispatch(new SendNewUserRegisteredForUserJob($user->email));
        if ($response = $this->registered($request, $user)) {
            return $response;
        }
        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect($this->redirectPath());

    }

    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'company_name' => ['required', 'string', 'max:255'],
            'field' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', function($attribute, $value,$fail)
            {
                if (str_contains($value, '@yahoo')
                    or str_contains($value, '@ymail')
                    or str_contains($value, '@gmail')
                    or str_contains($value, '@hotmail')
                    or str_contains($value, '@outlook')
                ) {
                    $fail('Please enter Company :attribute.',);
                }
            }],
            'mobile_number' => ['required', 'string'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'company_name' => $data['company_name'],
            'field' => $data['field'],
            'type' => 'User',
            'role_request_id' => $data['type'],
            'email' => $data['email'],
            'mobile_number' => $data['mobile_number'],
//            'password' => Hash::make($data['password']),
        ]);
    }
}
