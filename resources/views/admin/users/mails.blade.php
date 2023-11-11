@extends('admin.layouts')

@section('title')
    History Of User Mails
@endsection

@section('style')
    <style>
        th,td{
            width: auto !important;
        }

    </style>
@endsection

@section('script')

@endsection
@section('content')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 col-lg-3">
                    @include('admin.sidebar')
                </div>
                <div class="col-md-12 col-lg-9">
                    <div>
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    @include('admin.sections.alert')
                                    <div class="col-12">
                                        <a href="{{ route('admin.users.index',['type'=>$type]) }}"
                                           class="btn btn-secondary btn-sm mb-2">
                                            Back
                                        </a>
                                        <h5 class="text-white mb-2">
                                           Mails History
                                        </h5>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="markets-pair-list">
                                            <div id="alert"></div>
                                            <table class="table table-striped">
                                                <thead>
                                                <tr class="bg-dark">
                                                    <th class="text-white">#</th>
                                                    <th class="text-white">user</th>
                                                    <th class="text-white">email</th>
                                                    <th class="text-white">status</th>
                                                    <th class="text-white">created at</th>
                                                    <th class="text-white"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($mails as $key=>$item)
                                                    <tr>
                                                        <td>
                                                            {{ $mails->firstItem()+$key }}
                                                        </td>
                                                        <td>
                                                            {{ $item->User->name }}
                                                        </td>
                                                        <td>
                                                            {{ $item->User->email }}
                                                        </td>
                                                        <td class="{{ $item->status==1 ? 'text-success' : 'text-danger' }}">
                                                            {{ $item->status==1 ? 'delivered' : 'failed' }}
                                                        </td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}
                                                        </td>
                                                        <td class="d-flex justify-content-center">
                                                            <a href="{{ route('admin.user.mail',['type'=>$type,'user'=> $item->User->id,'mail'=>$item->id]) }}"
                                                               class="btn btn-sm btn-warning ">
                                                                <i class="icon ion-md-eye text-white"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                            <div class="text-center">
                                                <div class="d-flex justify-content-center mt-4">
                                                    {{ $mails->links() }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.sections.remove_modal')
@endsection

