@extends('admin.layouts.main')

@section('title')
    User Wallet
@endsection

@section('breadcrumb')
    <div class="col-md-12 mb-3">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ $user->name }}</h4>
        </div>
        <ul class="breadcrumb mt-3">
            <li class="breadcrumb-item active">{{ __('Dashboard') }}</li>
            <li class="breadcrumb-item active">{{ __('Users') }}</li>
            <li class="breadcrumb-item active">{{ __('waleet') }}</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div>
                <div>
                    <div class="card">
                        <div class="card-body">
                            <div class="col-12 mb-3">
                                <h5>
                                    <span>wallet: </span>
                                    <span>{{ $total_amount }}</span>
                                </h5>
                                <div>
                                    <label for="wallet">
                                        amount ($)
                                        <input id="wallet" class="form-control" name="wallet" value="0">
                                    </label>
                                    <button type="button" onclick="changeUserWallet({{ $user->id }},'incremental')"
                                            class="btn btn-success">
                                        incremental
                                    </button>
                                    <button type="button" onclick="changeUserWallet({{ $user->id }},'decremental')"
                                            class="btn btn-danger">
                                        decremental
                                    </button>
                                </div>

                                <div>
                                    <label for="wallet_description">Description *</label>
                                    <textarea id="wallet_description" class="form-control form-control-sm" name="wallet_description"></textarea>
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="markets-pair-list">
                                    <div id="alert"></div>
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>amount</th>
                                            <th>status</th>
                                            <th>type</th>
                                            <th>description</th>
                                            <th>created at</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($wallets as $key=>$item)
                                            <tr>
                                                <td>
                                                    {{ $key }}
                                                </td>
                                                <td>
                                                    {{ $item->amount }}
                                                </td>
                                                <td>
                                                    {{ $item->status }}
                                                </td>
                                                <td>
                                                    {{ $item->type }}
                                                </td>
                                                <td>
                                                    {{ $item->description }}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="text-center">
                                        <div class="d-flex justify-content-center mt-4">
                                            {{ $wallets->links() }}
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
@push('style')

@endpush
@push('script')
    <script>
        function changeUserWallet(user_id, type) {
            let amount = $('#wallet').val();
            let wallet_description = $('#wallet_description').val();
            if (amount<10){
                alert('minimum amount is 10$');
                return false;
            }
            if (wallet_description.length==0){
                alert('wallet description is required');
                return false;
            }
            $.ajax({
                url: "{{ route('admin.user.wallet.change') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    user_id: user_id,
                    type: type,
                    amount: amount,
                    wallet_description: wallet_description,
                },
                dataType: 'json',
                method: 'post',
                success: function (response) {
                    if (response[0]===1){
                        window.location.reload();
                    }
                },

            })
        }
    </script>
@endpush
