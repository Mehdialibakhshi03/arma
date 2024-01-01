<table class="table table-responsive-sm">
    <thead class="thead-dark">
    <tr>
        <th scope="col">#</th>
        <th scope="col">Price($)</th>
        <th scope="col">Quantity</th>
    </tr>
    </thead>
    <tbody>

    @foreach($bids as $key=>$bid)
    <tr>
        <td scope="col">{{ $key+1 }}</td>
        <td scope="col">{{ $bid->price }}</td>
        <td scope="col">{{ $bid->quantity }}</td>
    </tbody>
    @endforeach
</table>

