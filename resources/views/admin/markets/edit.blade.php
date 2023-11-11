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
                                        <a href="{{ route('admin.markets.index',['status'=>$status]) }}" class="btn btn-secondary btn-sm mb-2">
                                            <i class="icon ion-md-arrow-back mr-1"></i>
                                            <span>
                                                Back
                                            </span>
                                        </a>
                                    </div>
                                    <div class="settings-profile">
                                        <form method="POST" action="{{ route('admin.market.update',['status'=>$status,'market'=>$market->id]) }}">
                                            @csrf
                                            @method('put')
                                            <div class="row mt-4">
                                                <div class="col-12 col-md-9 mb-3">
                                                    <label for="title">Title</label>
                                                    <input id="title" type="text" name="title" class="form-control"
                                                           placeholder="title" value="{{ $market->title }}">
                                                    @error('title')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3 mb-3">
                                                    <label for="priority">Priority</label>
                                                    <input id="priority" type="text" name="priority" class="form-control"
                                                           placeholder="priority" value="{{ $market->priority }}">
                                                    @error('priority')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="description">Description</label>
                                                    <textarea name="description" id="description" class="form-control">{{ $market->description }}</textarea>
                                                    @error('description')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="start">Open Market At</label>
                                                    <input id="start" type="datetime-local" name="start" class="form-control"
                                                           value="{{ $market->start }}">
                                                    @error('start')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="end">Close Market At</label>
                                                    <input id="end" type="datetime-local" name="end" class="form-control"
                                                           placeholder="end" value="{{ $market->end }}">
                                                    @error('end')
                                                    <p class="input-error-validate">
                                                        {{ $message }}
                                                    </p>
                                                    @enderror
                                                </div>
                                                <div class="col-md-3">
                                                    <label>Commodity</label>
                                                    <select  id="FormValues" name="form_id[]" class="form-control my-select" data-live-search="true"
                                                             multiple>

                                                        @foreach ($form_values as $form_value)
                                                            <option {{ in_array($market->id,$form_value->Markets()->pluck('market_id')->toArray()) ? 'selected=selected' : '' }} value="{{ $form_value->id }}">
                                                                {{ $form_value->User->name.'/'.$form_value->getFormArray()[0][4]->value }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-12 mt-3">
                                                    <input type="submit" value="Edit">
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
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/css/bootstrap-select.min.css" integrity="sha512-ARJR74swou2y0Q2V9k0GbzQ/5vJ2RBSoCWokg4zkfM29Fb3vZEQyv0iWBMW/yvKgyHSR/7D64pFMmU8nYmbRkg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush

@push('script')
    <!-- MDB -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js" integrity="sha512-yDlE7vpGDP7o2eftkCiPZ+yuUyEcaBwoJoIhdXv71KZWugFqEphIS3PU60lEkFaz8RxaVsMpSvQxMBaKVwA5xg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('#FormValues').selectpicker({
            'title':'Select Commodity'
        });
    </script>
@endpush

