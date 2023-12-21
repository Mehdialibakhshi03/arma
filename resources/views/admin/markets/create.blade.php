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
                                              action="{{ route('admin.market.store') }}">
                                            @csrf
                                            <div class="row mt-4">
                                                <div class="col-12 col-md-3 mb-3">
                                                    <label for="date">start(Date)</label>
                                                    <input onchange="getDate(this)" id="date" type="date" name="date" class="form-control"
                                                           value="{{ old('date') }}">
                                                    <p id="DayName" class="mt-2">

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
                                                           value="{{ old('time') }}">
                                                    @error('time')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-3 mb-3">
                                                    <label for="min_wallet">min wallet for bidding ($)</label>
                                                    <input id="min_wallet" type="number" name="min_wallet" class="form-control"
                                                           value="{{ old('min_wallet') }}">
                                                    @error('min_wallet')
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
                                                            <option {{ old('commodity_id')==$item->id?'selected':'' }} value="{{ $item->id }}">Commodity:{{ $item->commodity }}/User:{{ $item->User->name }}</option>
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
    </script>
@endpush

