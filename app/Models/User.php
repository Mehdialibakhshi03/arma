<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Mail\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Spatie\MailTemplates\Models\MailTemplate;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'password', 'type', 'profile', 'active_status', 'email_verified_at', 'lang', 'created_by', 'country',
        'country_code', 'phone', 'isVerified', 'phone_verified_at', 'role_request_id', 'company_name', 'mobile_number'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function loginSecurity()
    {
        return $this->hasOne('App\Models\LoginSecurity');
    }

    public function currentLanguage()
    {
        return $this->lang;
    }


    public function getAvatarImageAttribute()
    {
        $avatar = Storage::exists($this->avatar) ? Storage::url($this->avatar) : Storage::url('uploads/avatar/avatar.png');
        // $avatar = $this->avatar ? Storage::url($this->avatar) : asset('vendor/avatar_image/avatar.png');
        return $avatar;
    }

    public function hasVerifiedPhone()
    {
        return !is_null($this->phone_verified_at);
    }

    public function lastCodeRemainingSeconds()
    {
        $temp = UserCode::where('user_id', '=', $this->id)->first();
        if (isset($temp)) {
            $seconds = $temp->updated_at->diffInSeconds(Carbon::now());
            // $seconds = 60;
            if ($seconds > 60) {
                return 60;
            } else {
                return 60 - $seconds;
            }
        } else {
            return 60;
        }
    }

    public function UserStatus()
    {
        return $this->belongsTo(UserStatus::class, 'active_status', 'id');
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class,'user_id');
    }
}
