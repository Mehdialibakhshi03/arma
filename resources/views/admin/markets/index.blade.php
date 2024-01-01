@extends('admin.layouts.main')

@section('title')
    {{ __('Markets') }}
@endsection

@section('breadcrumb')
    <div class="col-md-12 mb-3">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Markets') }}</h4>
        </div>
    </div>
@endsection
@section('content')
    <div class="settings mtb15">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                        <div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="col-md-12 mb-3">
                                        <a href="{{ route('admin.market.create') }}" class="btn btn-primary btn-sm">
                                            Create
                                        </a>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="markets-pair-list">
                                            <div id="alert"></div>
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>commodity</th>
                                                    <th>User</th>
                                                    <th>date</th>
                                                    <th>Time</th>
                                                    <th>status</th>
                                                    <th>action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($group_markets as $markets)
                                                @foreach($markets->sortBy('time') as $key=>$item)
                                                    <tr>
                                                        <td>
                                                            {{ $key }}
                                                        </td>
                                                        <td>
                                                            {{ $item->SalesForm->commodity }}
                                                        </td>
                                                        <td>
                                                            {{ $item->SalesForm->User->name }}
                                                        </td>
                                                        <td>
                                                            {{ $item->date }}
                                                        </td>
                                                        <td>
                                                            {{ $item->time }}
                                                        </td>
                                                        <td id="market_status_{{ $item->id }}" style="color: {{ $item->Status->color }}">
                                                            {{ $item->Status->title }}
                                                        </td>
                                                        <td>
                                                            <a title="Edit Market" href="{{ route('admin.market.edit', ['market'=>$item->id]) }}"
                                                               class="btn btn-sm btn-info">
                                                                <i class="fa fa-pen"></i>
                                                                 Market
                                                            </a>
                                                            <a title="Edit Commodity" href="{{ route('sale_form',['page_type'=>'Edit','item'=>$item->commodity_id]) }}"
                                                               class="btn btn-sm btn-primary">
                                                                <i class="fa fa-list"></i>
                                                                 Commodity
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                @endforeach
                                                </tbody>
                                            </table>
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
@push('style')
    @include('admin.layouts.includes.datatable_css')
@endpush
@push('script')
    <script>


        function removeModal(id, e) {
            e.stopPropagation();
            let remove_modal = $('#remove_modal');
            $('#id').val(id);
            remove_modal.modal('show');
        }

        function Remove() {
            let id = $('#id').val();
            $.ajax({
                url: "{{ route('admin.market.remove') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                dataType: "json",
                method: "post",
                beforeSend: function () {

                },
                success: function (msg) {
                    if (msg) {
                        $('#remove_modal').modal('hide');
                        if (msg[0] == 1) {
                            window.location.reload();
                        } else {
                            $('#alert').html(msg[1]);
                        }
                    }
                }
            })
        }
    </script>
@endpush
