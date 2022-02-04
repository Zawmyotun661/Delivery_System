<table>
    <thead>
        <tr>
            <th style="background-color: #f5f242;"> Date </th>
            <th style="background-color: #f5f242;">Customer Name</th>
            <th style="background-color: #f5f242;">Receiver Name</th>
            <th style="background-color: #f5f242;">Receiver Phone Number </th>
            <th style="background-color: #f5f242;">Receiver Address</th>
            <th style="background-color: #f5f242;">Township </th>
            <th style="background-color: #f5f242;">Amount </th>
            <th style="background-color: #f5f242;">Delivery Fee </th>
            <th style="background-color: #f5f242;">Deposit</th>
            <th style="background-color: #f5f242;">Driver Name </th>
            <th style="background-color: #f5f242;">Payment Status </th>
            <th style="background-color: #f5f242;">Delivery Status </th>
            <th style="background-color: #f5f242;"> Package Name </th>
            <th style="background-color: #f5f242;"> Package Size </th>
            <th style="background-color: #f5f242;">Remark</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($packages as $package)
            <tr>
                <td>{{ $package->date }}</td>
                <td>{{ $package->cus_name }}</td>
                <td>{{ $package->receiver_name }}</td>
                <td>{{ $package->phone }}</td>
                <td>{{ $package->address }}</td>
                <td>{{ $package->name }}</td>            {{-- show township name --}}
                <td>{{ $package->price }}</td>
                <td>{{ $package->delivery_fee }}</td>
                <td>{{ $package->deposit_amount }}</td>
                <td>{{ $package->driver_name }}</td>
                <td>{{ $package->payment_status }}</td>
                <td>{{ $package->status }}</td>
                <td>{{ $package->package_name }}</td>
                <td >{{ $package->package_size }}</td>
                <td>{{ $package->remark }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
            <tr>
                <th><strong>Total</strong></th>
                <th><strong>{{$total_price ?? ''}}</strong></th>
            </tr>
            <tr>
                <th><strong>Delivery_fee</strong></th>
                <th><strong>{{$amount_delivery ?? ''}}</strong></th>
            </tr>
        </tfoot>
</table>