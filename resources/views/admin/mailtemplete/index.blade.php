@extends('admin.layouts.main')
@section('title', __('Email Templates'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Email Templates') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item">{!! Html::link(route('home'), __('Dashboard'), []) !!}</li>
            <li class="breadcrumb-item active">{{ __('Email Templates') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row ">
        <div class="col-lg-12 ">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive pb-4 py-5">
                        <div class="container-fluid">
                            {{ $dataTable->table(['width' => '100%']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    @include('admin.layouts.includes.datatable_css')
@endpush
@push('script')
    @include('admin.layouts.includes.datatable_js')
    {{ $dataTable->scripts() }}
@endpush
