@extends('admin.layouts.main')

@section('content')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div id="settings-profile"
                             aria-labelledby="settings-profile-tab">
                            <div class="card">
                                <div class="card-body">
                                    <div class="settings-profile">
                                        <form method="POST" action="{{ route('admin.market.setting.update_setting') }}">
                                            @csrf
                                            @method('put')
                                            <div class="row mt-4">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="ready_to_duration">Ready To duration(TIME)</label>
                                                    <input id="ready_to_duration" type="time" name="ready_to_duration"
                                                           class="form-control"
                                                           placeholder="title" value="{{ $ready_to_duration }}">
                                                    @error('ready_to_duration')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="open_duration">Open duration(TIME)</label>
                                                    <input id="open_duration" type="time" name="open_duration"
                                                           class="form-control"
                                                           placeholder="title" value="{{ $open_duration }}">
                                                    @error('open_duration')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="q_1">Q-1 duration(TIME)</label>
                                                    <input id="q_1" type="time" name="q_1"
                                                           class="form-control" value="{{ $q_1 }}">
                                                    @error('q_1')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="q_2">Q-2 duration(TIME)</label>
                                                    <input id="q_2" type="time" name="q_2"
                                                           class="form-control" value="{{ $q_2 }}">
                                                    @error('q_2')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <button class="btn btn-primary btn-sm">
                                                        Update
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

@push('style')

@endpush

@push('script')

@endpush

