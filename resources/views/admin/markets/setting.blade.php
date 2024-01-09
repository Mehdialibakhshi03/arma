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
                                        <form method="POST"
                                              action="{{ route('admin.markets.settings.update') }}">
                                            @csrf
                                            <div class="row mt-4">
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="ready_to_open">Ready to Open(min)</label>
                                                    <input id="ready_to_open" type="number" name="ready_to_open"
                                                           class="form-control"
                                                           value="{{ $ready_to_open }}">
                                                    @error('ready_to_open')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="date">Opening(min)</label>
                                                    <input id="opening" type="number" name="opening"
                                                           class="form-control"
                                                           value="{{ $opening }}">
                                                    @error('opening')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="date">Quotation 1/2 (min)</label>
                                                    <input id="q_1" type="number" name="q_1" class="form-control"
                                                           value="{{ $q_1 }}">
                                                    @error('q_1')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>

                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="date">Quotation 2/2 (min)</label>
                                                    <input id="q_2" type="number" name="q_2" class="form-control"
                                                           value="{{ $q_2 }}">
                                                    @error('q_2')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 col-md-4 mb-3">
                                                    <label for="q_3">Competition(min)</label>
                                                    <input id="q_3" type="number" name="q_3" class="form-control"
                                                           value="{{ $q_3 }}">
                                                    @error('q_3')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="bid_deposit_text_area">Bid Deposit</label>
                                                    <textarea id="bid_deposit_text_area" name="bid_deposit_text_area"
                                                              class="form-control text_area">{{ $bid_deposit_text_area }}</textarea>
                                                    @error('bid_deposit_text_area')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="term_conditions">Term & Conditions</label>
                                                    <textarea id="term_conditions" name="term_conditions"
                                                              class="form-control text_area">{{ $term_conditions }}</textarea>
                                                    @error('term_conditions')
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
        CKEDITOR.replace('bid_deposit_text_area', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('term_conditions', {
            filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush

