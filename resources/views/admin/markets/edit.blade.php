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
                                                    <input id="start" type="datetime-local" name="start"
                                                           class="form-control"
                                                           value="{{ $market->start }}">
                                                    @error('start')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="min_wallet">min wallet for bidding ($)</label>
                                                    <input id="min_wallet" type="number" name="min_wallet"
                                                           class="form-control"
                                                           value="{{ $market->min_wallet }}">
                                                    @error('min_wallet')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="min_wallet">Commodity</label>
                                                    <select class="form-control" name="commodity_id">
                                                        <option value="">select</option>
                                                        @foreach($sales_offer_form_copy as $item)
                                                            <option {{ $market->commodity_id==$item->id?'selected':'' }} value="{{ $item->id }}">
                                                                Commodity:{{ $item->commodity }}
                                                                /User:{{ $item->User->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('commodity_id')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <button type="submit" class="btn btn-primary btn-block btn-sm">
                                                        Create
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

