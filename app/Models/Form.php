<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    public $fillable = [
        'title', 'json', 'html', 'logo', 'success_msg', 'thanks_msg', 'email', 'amount', 'currency_symbol', 'currency_name',
        'payment_status', 'payment_type','bccemail','ccemail','allow_comments','allow_share_section','assign_type', 'created_by',
    ];

    public function getFormArray()
    {
        return json_decode($this->json);
    }

    public function Roles()
    {
        return $this->belongsToMany('Spatie\Permission\Models\Role', 'user_forms', 'form_id', 'role_id');
    }

    public function User()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function assignFormRoles($role_ids)
    {
        $roles = $this->Roles->pluck('name', 'id')->toArray();
        if ($role_ids) {
            foreach ($role_ids as $id) {
                if (!array_key_exists($id, $roles)) {
                    UserForm::create(['form_id' => $this->id, 'role_id' => $id]);
                } else {
                    unset($roles[$id]);
                }
            }
        }
        if ($roles) {
            foreach ($roles as $id => $name) {
                UserForm::where(['form_id' => $this->id, 'role_id' => $id])->delete();
            }
        }
    }

    public function commmant()
    {
        return $this->hasMany(FormComments::class, 'form_id', 'id');
    }

    //assign form user
    public function assignedusers()
    {
        return $this->belongsToMany(User::class, 'assign_forms_users', 'form_id', 'user_id');
    }

    public function assignUser($users_ids)
    {
        $form_users = $this->assignedusers->pluck('name', 'id')->toArray();
        if ($users_ids) {
            foreach ($users_ids as $id) {
                if (!array_key_exists($id, $form_users)) {
                    AssignFormsUsers::create(['form_id' => $this->id, 'user_id' => $id]);
                } else {
                    unset($form_users[$id]);
                }
            }
        }
        if ($form_users) {
            foreach ($form_users as $id => $name) {
                AssignFormsUsers::where(['form_id' => $this->id, 'user_id' => $id])->delete();
            }
        }
    }

    //assign form roles
    public function assignedroles()
    {
        return $this->belongsToMany('Spatie\Permission\Models\Role', 'assign_forms_roles', 'form_id', 'role_id');
    }

    public function assignRole($users_ids)
    {
        $form_roles = $this->assignedroles->pluck('name', 'id')->toArray();
        if ($users_ids) {
            foreach ($users_ids as $id) {
                if (!array_key_exists($id, $form_roles)) {
                    AssignFormsRoles::create(['form_id' => $this->id, 'role_id' => $id]);
                } else {
                    unset($form_roles[$id]);
                }
            }
        }
        if ($form_roles) {
            foreach ($form_roles as $id => $name) {
                AssignFormsRoles::where(['form_id' => $this->id, 'role_id' => $id])->delete();
            }
        }
    }
}
