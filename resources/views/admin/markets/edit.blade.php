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
                                                <div class="col-12 col-md-3 mb-3">
                                                    <label for="date">start(Date)</label>
                                                    <input onchange="getDate(this)" id="date" type="date" name="date"
                                                           class="form-control"
                                                           value="{{ $market->date }}">
                                                    <p id="DayName" class="mt-2">
                                                        {{ Carbon\Carbon::parse($market->date)->dayName }}
                                                    </p>
                                                    @error('date')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-3 mb-3">
                                                    <label for="start">start(Time)</label>
                                                    <input id="start" type="time" name="time" class="form-control"
                                                           value="{{ $market->time }}">
                                                    @error('time')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-3 mb-3">
                                                    <label for="bid_deposit">Bid Deposit</label>
                                                    <input id="bid_deposit"  name="bid_deposit" class="form-control"
                                                           value="{{ $market->bid_deposit }}">
                                                    @error('bid_deposit')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-3 mb-3">
                                                    <label for="min_wallet">Commodity</label>
                                                    <select class="form-control" name="commodity_id">
                                                        <option value="">select</option>
                                                        @foreach($sales_offer_form_copy as $item)
                                                            <option
                                                                {{ $market->commodity_id==$item->id?'selected':'' }} value="{{ $item->id }}">
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
                                                <div class="col-12 col-md-3 mb-3">
                                                    <label for="offer_price">Offer Price</label>
                                                    <input id="offer_price"  name="offer_price" class="form-control"
                                                           value="{{ $market->offer_price }}" type="number">
                                                    @error('offer_price')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-3 mb-3">
                                                    <label for="step_price_competition">Step Price In Competition</label>
                                                    <input id="step_price_competition" name="step_price_competition" min="1" class="form-control"
                                                           value="{{ $market->step_price_competition }}">
                                                    @error('step_price_competition')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="description">Description</label>
                                                    <textarea id="description"  name="description" class="form-control">{{ $market->description }}</textarea>
                                                    @error('description')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <button type="submit" class="btn btn-primary btn-block btn-sm">
                                                        Edit
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
    <script>
        function getDate(tag) {
            let date = $(tag).val();
            date = date.replaceAll('-', '/', date);
            date = new Date(date);

            let day = date.getDay();
            let DayName;
            if (day === 0) {
                DayName = "Sunday";
            } else if (day === 1) {
                DayName = "Monday";
            } else if (day === 2) {
                DayName = "Tuesday";
            } else if (day === 3) {
                DayName = "Wednesday";
            } else if (day === 4) {
                DayName = "Thursday";
            } else if (day === 5) {
                DayName = "Friday";
            } else if (day === 6) {
                DayName = "Saturday";
            }
            $('#DayName').text(DayName);
        }
        CKEDITOR.replace('description', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush

