@extends('admin.layouts.main')

@section('title')
    {{ $user_status }} Users
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('#new_password').val(' ');
        })

        // Generate a Password string
        function randString() {
            var dataSet = $('#new_password').attr('data-character-set').split(',');
            var possible = '';
            if ($.inArray('a-z', dataSet) >= 0) {
                possible += 'abcdefghijklmnopqrstuvwxyz';
            }
            if ($.inArray('A-Z', dataSet) >= 0) {
                possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            }
            if ($.inArray('0-9', dataSet) >= 0) {
                possible += '0123456789';
            }
            if ($.inArray('#', dataSet) >= 0) {
                possible += '![]{}()%&*$#^<>~@|';
            }
            console.log(possible);
            var text = '';
            for (var i = 0; i < 20; i++) {
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            }
            console.log(text);
            $('#new_password').val(text);
        }

        CKEDITOR.replace('message', {
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });

        CKEDITOR.replace('note', {
            filebrowserUploadUrl: "{{route('upload', ['_token' => csrf_token() ])}}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="tab-content" id="v-pills-tabContent">
                <div id="settings-profile"
                     aria-labelledby="settings-profile-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-white">
                                        Edit User
                                        <hr>
                                    </div>
                                    <div class="settings-profile">
                                        <form method="POST"
                                              action="{{ route('admin.user.update',['type'=>$type,'user'=>$user->id]) }}">
                                            @csrf
                                            @method('put')
                                            <div class="row mt-4">
                                                <div class="col-md-6 mb-2">
                                                    <label for="name">Name</label>
                                                    <input id="name" type="text" name="name"
                                                           class="form-control"
                                                           placeholder="Name" value="{{ $user->name }}">
                                                    @error('name')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <label for="email">Email</label>
                                                    <input id="email" type="text" name="email"
                                                           class="form-control"
                                                           placeholder="Email" value="{{ $user->email }}">
                                                    @error('name')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <label for="company_name">Company Name</label>
                                                    <input id="company_name" type="text" name="company_name"
                                                           class="form-control"
                                                           placeholder="Company Name"
                                                           value="{{ $user->company_name }}">
                                                    @error('company_name')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-2">
                                                    <label for="field">Field</label>
                                                    <input id="field" type="text" name="field"
                                                           class="form-control"
                                                           placeholder="Field" value="{{ $user->field }}">
                                                    @error('field')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="role_request_id">Select User Type</label>
                                                    <select
                                                        id="role_request_id"
                                                        type="text"
                                                        class="form-control"
                                                        name="role_request_id">
                                                        @if($user->type!='Admin')
                                                            <option value="0">Nothing</option>
                                                            @foreach($userTypes as $type)
                                                                <option
                                                                    {{ $user->role_request_id==$type->id ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                                                            @endforeach
                                                        @else
                                                            <option value="1">Admin</option>
                                                        @endif
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="mobile_number">Mobile Number</label>
                                                    <input id="mobile_number" type="text" name="mobile_number"
                                                           class="form-control"
                                                           placeholder="Mobile Number"
                                                           value="{{ $user->mobile_number }}">
                                                    @error('mobile_number')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-2">
                                                    <label for="status">User Status</label>
                                                    <select name="active_status" id="status"
                                                            class="form-control">
                                                        @foreach($userStatus as $status)
                                                            <option
                                                                {{ $user->active_status == $status->id ? 'selected' : ' ' }} value="{{ $status->id }}">{{ $status->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 mb-3 mb-2">
                                                    <label for="note">Note:</label>
                                                    <textarea rows="5" id="note" name="note"
                                                              class="form-control">{{ $user->note }}</textarea>
                                                </div>
                                                <div class="col-md-12">
                                                    <button class="btn btn-info btn-sm mb-2" type="submit">
                                                        Update
                                                    </button>
                                                    <a href="{{ route('admin.users.index',['type'=>$type]) }}"
                                                       class="btn btn-secondary btn-sm mb-2">
                                                        Back
                                                    </a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-white">
                                        Send Message
                                        <hr>
                                    </div>
                                    <div class="settings-profile">
                                        <form method="POST"
                                              action="{{ route('admin.user.sendMessage',['user'=>$user->id]) }}">
                                            @csrf
                                            <div class="row mt-4">
                                                <div class="col-md-6 mb-2">
                                                    <label for="title">Subject</label>
                                                    <input id="title" type="text" name="title"
                                                           class="form-control" value="{{ old('title') }}">
                                                    @error('title')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-2">
                                                    <label for="message">Message:</label>
                                                    <textarea rows="10" id="message" name="message"
                                                              class="form-control">{{ old('message') }}</textarea>
                                                    @error('message')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <button class="btn btn-info btn-sm mb-2" type="submit"> Send
                                                        Email
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-white">
                                        Reset Password
                                        <hr>
                                    </div>
                                    <div class="settings-profile">
                                        <form method="POST"
                                              action="{{ route('admin.user.reset_password',['user'=>$user->id]) }}">
                                            @csrf
                                            <div class="row mt-4">
                                                <div class="col-12 position-relative mb-3">
                                                    <label for="new_password">Generate Password</label>
                                                    <input name="new_password" id="new_password"
                                                           class="form-control"
                                                           data-character-set="a-z,A-Z,0-9,#">
                                                    @error('new_password')
                                                    <p class="input-error-validate position-absolute">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                    <button style="bottom: 0;right: 0" onclick="randString()"
                                                            class="btn btn-info position-absolute"
                                                            type="button">
                                                        Generate Password
                                                    </button>
                                                </div>
                                                <div class="col-md-12">
                                                    <button class="btn btn-info btn-sm mb-2" type="submit">
                                                        Reset Password
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

