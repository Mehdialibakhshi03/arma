@extends('admin.layouts')
@section('title')
    History Of User Mails - message
@endsection

@section('script')

@endsection
@section('content')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-3">
                    @include('admin.sidebar')
                </div>
                <div class="col-md-12 col-lg-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div id="settings-profile"
                             aria-labelledby="settings-profile-tab">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            @include('admin.sections.alert')
                                            <div class="text-white">
                                                Message
                                                <hr>
                                            </div>
                                            <div class="settings-profile">
                                                <div class="form-row mt-4">
                                                    <div class="col-md-6">
                                                        <label for="name">User</label>
                                                        <input disabled id="name" type="text"
                                                               class="form-control"
                                                               value="{{ $mail->User->name }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="email">Email</label>
                                                        <input disabled id="email" type="text" name="email"
                                                               class="form-control"
                                                              value="{{ $mail->User->email }}">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="date">date</label>
                                                        <input disabled id="date" type="text" name="email"
                                                               class="form-control"
                                                               value="{{ $mail->created_at }}">
                                                    </div>

                                                    <div class="col-12 mb-3">
                                                        <label for="message">Message:</label>
                                                        <div style="background-color: #e9ecef;padding: 20px">
                                                            {!! $mail->message !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <a href="{{ route('admin.user.mails',['type'=>$type,'user'=>$mail->User->id]) }}"
                                                           class="btn btn-secondary btn-sm mb-2">
                                                            Back
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

