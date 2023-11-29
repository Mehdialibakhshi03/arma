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
                                                    <label for="ready_to_duration">Ready To duration(min)</label>
                                                    <input id="ready_to_duration" type="number" name="ready_to_duration"
                                                           class="form-control" value="{{ $ready_to_duration }}">
                                                    @error('ready_to_duration')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="open_duration">Open duration(min)</label>
                                                    <input id="open_duration" type="number" name="open_duration"
                                                           class="form-control"
                                                           value="{{ $open_duration }}">
                                                    @error('open_duration')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="q_1">Q-1 duration(min)</label>
                                                    <input id="q_1" type="number" name="q_1"
                                                           class="form-control" value="{{ $q_1 }}">
                                                    @error('q_1')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="q_2">Q-2 duration(min)</label>
                                                    <input id="q_2" type="number" name="q_2"
                                                           class="form-control" value="{{ $q_2 }}">
                                                    @error('q_2')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="q_3">Q-3 duration(min)</label>
                                                    <input id="q_3" type="number" name="q_3"
                                                           class="form-control" value="{{ $q_3 }}">
                                                    @error('q_3')
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

