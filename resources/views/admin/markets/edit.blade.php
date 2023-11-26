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
                                    <div>
                                        <a href="{{ route('admin.markets.index') }}"
                                           class="btn btn-secondary btn-sm mb-2">
                                            <i class="icon ion-md-arrow-back mr-1"></i>
                                            <span>
                                                Back
                                            </span>
                                        </a>
                                    </div>
                                    <div class="settings-profile">
                                        <form method="POST"
                                              action="{{ route('admin.market.update',['market'=>$market->id]) }}">
                                            @csrf
                                            @method('put')
                                            <div class="row mt-4">
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="start">start</label>
                                                    <input id="start" type="datetime-local" name="start" class="form-control"
                                                           value="{{ $market->start }}">
                                                    @error('start')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="end">end</label>
                                                    <input id="end" type="datetime-local" name="end" class="form-control"
                                                           value="{{ $market->end }}">
                                                    @error('end')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="min_price">min wallet for bidding ($)</label>
                                                    <input id="min_price" type="number" name="min_price" class="form-control"
                                                           value="{{ $market->min_price }}">
                                                    @error('min_price')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>


                                                <div class="col-md-12 mt-3">
                                                    <button type="submit" class="btn btn-primary btn-block btn-sm">
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

