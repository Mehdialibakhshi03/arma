@php
    $user=\Illuminate\Support\Facades\Auth::user();
@endphp
@php
    $pending_count=\App\Models\FormValue::where('status',0)->where('user_id',$user->id)->count();
@endphp
<li class="dash-item d-flex align-items-center">
    <a href="/forms/fill/1" class="dash-link"><span
            class="dash-mtext custom-weight">
                         <span class="dash-micon">
                                <i class="ti ti-table"></i>
                            </span>
        {{ __('New Offer Request') }}
    </a>
</li>
<li class="dash-item">
    <a href="#!" class="dash-link position-relative">
                                <span class="dash-micon">
                                <i class="ti ti-table"></i>
                            </span>

        <span
            class="dash-mtext custom-weight">{{ __('My Offer') }}</span><span
            class="dash-arrow"><i data-feather="chevron-right"></i></span>
        @if($pending_count>0)
            <span class="circle-notification circle-notification-absolute">{{ $pending_count }}</span>
        @endif
    </a>


    <ul
        class="dash-submenu {{ Request::route()->getName() == 'view.form.values' ? 'd-block' : '' }}">
        <li class="dash-item d-flex align-items-center">
            <a href="{{ route('view.form.values',['status'=>3,'user'=>$user->id]) }}" class="dash-link"><span
                    class="dash-mtext custom-weight">{{ __('Preview Form') }}
            </a>
        </li>
        <li class="dash-item d-flex align-items-center">
            <a href="{{ route('view.form.values',['status'=>0,'user'=>$user->id]) }}" class="dash-link"><span
                    class="dash-mtext custom-weight">{{ __('Pending') }}
            </a>

            @if($pending_count>0)
                <span class="circle-notification">{{ $pending_count }}</span>
            @endif
        </li>
        <li class="dash-item d-flex align-items-center">
            <a href="{{ route('view.form.values',['status'=>2,'user'=>$user->id]) }}" class="dash-link"><span
                    class="dash-mtext custom-weight">{{ __('Denied') }}
            </a>
        </li>
        <li class="dash-item d-flex align-items-center">
            <a href="{{ route('view.form.values',['status'=>1,'user'=>$user->id]) }}" class="dash-link font10pt"><span
                    class="dash-mtext custom-weight">{{ __('Approved Commodity') }}
            </a>
        </li>
        {{--                                @foreach ($forms as $form)--}}
        {{--                                    <li class="dash-item">--}}
        {{--                                        <a class="dash-link {{ Request::route()->getName() == 'view.form.values' ? 'show' : '' }}"--}}
        {{--                                           href="{{ route('view.form.values', $form->id) }}">{{ $form->title }}</a>--}}
        {{--                                    </li>--}}
        {{--                                @endforeach--}}
    </ul>
</li>
