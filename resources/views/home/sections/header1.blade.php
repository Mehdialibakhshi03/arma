<div id="scroll-container" class="bg-white header1 d-flex">
    <div class="p-3 text-center">
            @foreach($header1 as $item)
                <span>
            <span class="mr-2">{{ $item->title }}</span>
            @if($item->number_2>0)
                        @php
                            $class='text-success';
                        @endphp
                    @elseif($item->number_2<0)
                        @php
                            $class='text-danger';
                        @endphp
                    @else
                        @php
                            $class='text-muted';
                        @endphp
                    @endif
            <span class="{{ $class }} mr-1">{{ $item->number_2 }}</span>
            @if($item->number_1>0)
                        @php
                            $class='text-success';
                        @endphp
                    @elseif($item->number_1<0)
                        @php
                            $class='text-danger';
                        @endphp
                    @else
                        @php
                            $class='text-muted';
                        @endphp
                    @endif
            <span class="{{ $class }} mr-1">{{ $item->number_1 }}</span>
            @if($item->number_3>0)
                        @php
                            $class='text-success';
                        @endphp
                    @elseif($item->number_3<0)
                        @php
                            $class='text-danger';
                        @endphp
                    @else
                        @php
                            $class='text-muted';
                        @endphp
                    @endif
            <span class="{{ $class }}">( {{ $item->number_3 }} %)</span>
            <span class="header1Pi">|</span>
        </span>
            @endforeach
    </div>
    <div class="p-3 text-center">
            @foreach($header1 as $item)
                <span>
            <span class="mr-2">{{ $item->title }}</span>
            @if($item->number_2>0)
                        @php
                            $class='text-success';
                        @endphp
                    @elseif($item->number_2<0)
                        @php
                            $class='text-danger';
                        @endphp
                    @else
                        @php
                            $class='text-muted';
                        @endphp
                    @endif
            <span class="{{ $class }} mr-1">{{ $item->number_2 }}</span>
            @if($item->number_1>0)
                        @php
                            $class='text-success';
                        @endphp
                    @elseif($item->number_1<0)
                        @php
                            $class='text-danger';
                        @endphp
                    @else
                        @php
                            $class='text-muted';
                        @endphp
                    @endif
            <span class="{{ $class }} mr-1">{{ $item->number_1 }}</span>
            @if($item->number_3>0)
                        @php
                            $class='text-success';
                        @endphp
                    @elseif($item->number_3<0)
                        @php
                            $class='text-danger';
                        @endphp
                    @else
                        @php
                            $class='text-muted';
                        @endphp
                    @endif
            <span class="{{ $class }}">( {{ $item->number_3 }} %)</span>
            <span class="header1Pi">|</span>
        </span>
            @endforeach
    </div>
</div>
