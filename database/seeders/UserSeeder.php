<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\settings;
use App\Models\SmsTemplate;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\MailTemplates\Models\MailTemplate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'manage-permission', 'create-permission', 'edit-permission', 'delete-permission',
            'manage-role', 'create-role', 'edit-role', 'delete-role',
            'manage-mailtemplate', 'create-mailtemplate', 'edit-mailtemplate', 'delete-mailtemplate',
            'manage-user', 'create-user', 'edit-user', 'delete-user',
            'manage-module', 'create-module', 'edit-module', 'delete-module',
            'manage-setting',
            'manage-form', 'create-form', 'edit-form', 'delete-form',
            'design-form',
            'fill-form',
            'duplicate-form',
            'show-submitted-form',
            'manage-submitted-form',
            'edit-submitted-form',
            'delete-submitted-form',
            'download-submitted-form',
            'create-language',
            'manage-language',
            'manage-chat',
            'manage-poll', 'create-poll', 'edit-poll', 'delete-poll','vote-poll','result-poll',
            'manage-dashboardwidget', 'create-dashboardwidget', 'edit-dashboardwidget', 'delete-dashboardwidget','vote-dashboardwidget','result-dashboardwidget',
            'manage-frontend', 'create-frontend', 'edit-frontend', 'delete-frontend',
            'manage-faqs', 'create-faqs', 'edit-faqs', 'delete-faqs',
        ];

        $modules = [
            'module', 'role', 'user', 'permission', 'setting', 'form', 'mailtemplate', 'submitted-form', 'language', 'chat','poll','dashboardwidget','frontend','faqs',
        ];

        $settings = [
            ['key' => 'app_name', 'value' => 'Prime Laravel Form Builder'],
            ['key' => 'app_logo', 'value' => 'uploads/appLogo/app-logo.png'],
            ['key' => 'app_small_logo', 'value' => 'uploads/appLogo/app-small-logo.png'],
            ['key' => 'favicon_logo', 'value' => 'uploads/appLogo/app-favicon-logo.png'],
            ['key' => 'default_language', 'value' => 'en'],
            ['key' => 'color', 'value' => 'theme-1'],
            ['key' => 'app_dark_logo', 'value' => 'uploads/appLogo/app-dark-logo.png'],
            ['key' => 'settingtype', 'value' => 'local'],
            ['key' => 'date_format','value' => 'M j, Y'],
            ['key' => 'time_format','value' => 'g:i A'],
            ['key' => 'roles','value' => 'User'],
        ];
        foreach ($settings as $setting) {
            settings::create($setting);
        }

        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        $role = Role::create([
            'name' => 'Admin'
        ]);

        foreach ($permissions as $permission) {
            $per = Permission::findByName($permission);
            $role->givePermissionTo($per);
        }

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
            'active_status' => '1',
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'phone_verified_at' => Carbon::now()->toDateTimeString(),
            'avatar' => ('uploads/avatar/avatar.png'),
            'type' => 'Admin',
            'lang' => 'en',
        ]);

        $user->assignRole($role->id);
        Role::create([
            'name' => 'User'
        ]);
        foreach ($modules as $module) {
            Module::create([
                'name' => $module
            ]);
        }

        MailTemplate::create([
            'mailable' => 'App\Mail\TestMail',
            'subject' => 'Mail send for testing purpose',
            'html_template' => '<p><strong>This Mail For Testing</strong></p>
            <p><strong>Thanks</strong></p>',
            'text_template' => null,
        ]);

        MailTemplate::create([
            'mailable' => 'App\Mail\Thanksmail',
            'subject' => 'New survey Submited - {{ title }}',
            'html_template' => '<div class="section-body">
            <div class="row mx-0">
            <div class="col-6 mx-auto">
            <div class="card">
            <div class="card-header">
            <h4 class="text-center w-100">{{ title }}</h4>
            </div>
            <div class="card-body">
            <div class="text-center">
            <img src="{{image}}" id="app-dark-logo" class="img img-responsive my-5 w-30 justify-content-center text-center"/>
            </div>
            <h2 class="text-center w-100">{{ thanks_msg }}</h2>
            </div>
            </div>
            </div>
            </div>
            </div>',
            'text_template' => null,
        ]);

        MailTemplate::create([
            'mailable' => 'App\Mail\PasswordReset',
            'subject' => 'Reset Password Notification',
            'html_template' => '<p><strong>Hello!</strong></p><p>You are receiving this email because we received a password reset request for your account. To proceed with the password reset please click on the link below:</p><p><a href="{{url}}">Reset Password</a></p><p>This password reset link will expire in 60 minutes.&nbsp;<br>If you did not request a password reset, no further action is required.</p>',
            'text_template' => null,
        ]);

        MailTemplate::create([
            'mailable' => \App\Mail\ConatctMail::class,
            'subject' => 'New Enquiry Details.',
            'html_template' => '<p><strong>Name : {{name}}</strong></p>

            <p><strong>Email : </strong><strong>{{email}}</strong></p>

            <p><strong>Contact No : {{ contact_no }}&nbsp;</strong></p>

            <p><strong>Message :&nbsp;</strong><strong>{{ message }}</strong></p>',
            'text_template' => null,
        ]);

        SmsTemplate::create([
            'event' => 'test_sms',
            'template' => 'Hello :name, Your verification code is :code',
            'variables' => 'name'
        ]);
    }
}
