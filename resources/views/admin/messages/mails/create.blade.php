@extends('admin.layouts')
@section('title')
    Messages
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
                            <div class="card">
                                <div class="card-body">
                                    <div>
                                        <a href="{{ route('admin.header1.index') }}" class="btn btn-secondary btn-sm mb-2">
                                            <i class="icon ion-md-arrow-back mr-1"></i>
                                            <span>
                                                Back
                                            </span>
                                        </a>
                                    </div>
                                    <div class="settings-profile">
                                        <form method="POST" action="{{ route('admin.header1.store') }}">
                                            @csrf
                                            <div class="form-row mt-4">
                                                <div class="col-md-6">
                                                    <label for="title">Title</label>
                                                    <input id="title" type="text" name="title" class="form-control"
                                                           placeholder="title" value="{{ old('title') }}">
                                                    @error('title')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="number_1">Number 1(min)</label>
                                                    <input id="number_1" type="text" name="number_1" class="form-control"
                                                           placeholder="Number 1(min)" value="{{ old('number_1') }}">
                                                    @error('number_1')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="number_2">Number 2(max)</label>
                                                    <input id="number_2" type="text" name="number_2" class="form-control"
                                                           placeholder="Number 2(max)" value="{{ old('number_2') }}">
                                                    @error('number_2')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="number_3">Number 3(percent)</label>
                                                    <input id="number_3" type="text" name="number_3" class="form-control"
                                                           placeholder="Number 3(percent)" value="{{ old('number_3') }}">
                                                    @error('number_3')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="priority">priority</label>
                                                    <input id="priority" type="text" name="priority" class="form-control"
                                                           placeholder="priority" value="{{ old('priority') }}">
                                                    @error('priority')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12">
                                                    <input type="submit" value="Create">
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

