@foreach($bids as $bid)
    <tr>
        <td class="text-center">{{ $bid->quantity }}</td>
        <td class="text-center">{{ $bid->price }}</td>
    </tr>
@endforeach
