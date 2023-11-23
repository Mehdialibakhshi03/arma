<table class="table table-striped">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Commodity</th>
        <th scope="col">Quantity</th>
        <th scope="col">Packing</th>
        <th scope="col">Delivery Term</th>
        <th scope="col">Region</th>
        <th scope="col">Date</th>
        <th scope="col">Time</th>
        <th scope="col"></th>
        <th scope="col"></th>
    </tr>
    </thead>
    <tbody>
    @for($i=0;$i<20;$i++)
        @if($i==1 or $i==2 or $i==8)
                <?php
                $color = 'red';
                ?>
        @else
                <?php
                $color = 'blue';
                ?>
        @endif
        <tr style="color: {{ $color }}">
            <td>Urea Granular</td>
            <td>30,000</td>
            <td>Bulk</td>
            <td>FOB</td>
            <td>Middle East Gulf</td>
            <td>2023.11.12</td>
            <td>Closed</td>
            <td>more
                <i class="fa fa-arrow-down"></i>
            </td>
            <td>
                <button class="btn btn-primary bid-bottom btn-sm">
                    Bid
                </button>
            </td>
        </tr>
    @endfor
    </tbody>
</table>

