
@if(count($markets)>0)
    <div class="landing-feature">
        <div class="container">
            <div class="row">
                @foreach($markets as $market)
                    <div class="col-md-12">
                        <h2>{{ $market->title }}</h2>
                        <p>
                            {{ $market->description }}
                        </p>
                    </div>
                    <div class="col-12">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Commodity</th>
                                <th scope="col">Type</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Delivery Term</th>
                                <th scope="col">Packing</th>
                                <th scope="col">Region</th>
                                <th scope="col">Minimum Price</th>
                                <th scope="col">Contract Type</th>
                                <th scope="col">more</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($market->FormValues as $key => $value)
                                <tr>
                                    <th scope="row">1</th>
                                    <td>{{ $value->getFormArray()[0][5]->value }}</td>
                                    <td>{{ $value->getFormArray()[0][6]->value }}</td>
                                    <td>-</td>
                                    <td>
                                        @foreach($value->getFormArray()[0][34]->values as $item)
                                            {{  isset($item->selected) ? $item->value : '' }}

                                        @endforeach

                                    </td>
                                    <td>
                                        @foreach($value->getFormArray()[0][59]->values as $item)
                                            {{  isset($item->selected) ? $item->value : '' }}

                                        @endforeach

                                    </td>
                                    <td>
                                        {{--                                        //Region--}}
                                        -
                                    </td>
                                    <td>
                                        {{--                                        //Minimum Price--}}
                                        -
                                    </td>
                                    <td>
                                        {{--                                        //Contract Type--}}
                                        -
                                    </td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                                data-target="#exampleModal">More
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
