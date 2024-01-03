@foreach($bids as $key=>$bid)
    <tr>
        <td class="text-center">{{ $bid->quantity }}</td>
        <td class="text-center">{{ $bid->price }}</td>
        <td class="text-center">
            @if($key!=0 and $bid->user_id==auth()->id() and $bid->Market->status==3 )
                <span class="remove_function" onclick="removeBid({{ $bid->id }})">
                     <i  class="fa fa-times-circle text-danger"></i>
                </span>
            @endif
        </td>
    </tr>
@endforeach
