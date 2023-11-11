<div id="scroll-container2" class="header2 d-flex">
    <div class="p-3 text-center">
            @foreach($header2 as $item)
                @if($item->number_3>0)
                    @php
                        $color='#137713';
                    @endphp
                @elseif($item->number_3<0)
                    @php

                        $color='#dc3545';
                    @endphp
                @else
                    @php
                        $color='#6c757d';
                    @endphp
                @endif
                <span style="display: inline-block">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="animation_main_div">
                              <div class="circle " style="background-color: {{ $color }} !important;"></div>
                              <div class="circle2" style="background-color: {{ $color }} !important;"></div>
                              <div class="circle3" style="background-color: {{ $color }} !important;"></div>
                              <div class="circle4" style="background-color: {{ $color }} !important;"></div>
                              <div class="logo-div-send">
                              <!--logo or anything put here -->
                              </div>
                        </div>
                        <span class="mr-2 header2Title">{{ $item->title }}</span>
                    </div>
                    <div style="width: 80px">
                        <div>
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
                <span class="{{ $class }}">{{ $item->number_2 }}</span>
                             <span>-</span>
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
                <span class="{{ $class }}">{{ $item->number_1 }}</span>
                        </div>
                        <div class="text-center">
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
                        </div>
                    </div>
                    <span class="header2Pi">|</span>
                </div>

        </span>
            @endforeach
    </div>
    <div class="p-3 text-center">
            @foreach($header2 as $item)
                @if($item->number_3>0)
                    @php
                        $color='#137713';
                    @endphp
                @elseif($item->number_3<0)
                    @php

                        $color='#dc3545';
                    @endphp
                @else
                    @php
                        $color='#6c757d';
                    @endphp
                @endif
                <span style="display: inline-block">
                <div class="d-flex align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="animation_main_div">
                              <div class="circle " style="background-color: {{ $color }} !important;"></div>
                              <div class="circle2" style="background-color: {{ $color }} !important;"></div>
                              <div class="circle3" style="background-color: {{ $color }} !important;"></div>
                              <div class="circle4" style="background-color: {{ $color }} !important;"></div>
                              <div class="logo-div-send">
                              <!--logo or anything put here -->
                              </div>
                        </div>
                        <span class="mr-2 header2Title">{{ $item->title }}</span>
                    </div>
                    <div style="width: 80px">
                        <div>
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
                <span class="{{ $class }}">{{ $item->number_2 }}</span>
                             <span>-</span>
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
                <span class="{{ $class }}">{{ $item->number_1 }}</span>
                        </div>
                        <div class="text-center">
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
                        </div>
                    </div>
                    <span class="header2Pi">|</span>
                </div>

        </span>
            @endforeach
    </div>
</div>
