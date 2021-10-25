<table>
    <thead>
        <tr>
            <th style="width: 15px; background-color: #f5f242;"> Date </th>
            <th style="width: 30px; background-color: #f5f242;">Receiver Name</th>
            <th style="width: 25px; background-color: #f5f242;">Receiver Phone Number </th>
            <th style="width: 50px; background-color: #f5f242;">Receiver Address</th>
            <th style="width: 20px; background-color: #f5f242;">Township </th>
            <th style="width: 15px; background-color: #f5f242;">Amount </th>
            <th style="width: 15px; background-color: #f5f242;">Delivery Fee </th>
            <th style="width: 15px; background-color: #f5f242;">Deposit</th>
            <th style="width: 15px; background-color: #f5f242;">Driver Name </th>
            <th style="width: 15px; background-color: #f5f242;">Payment Status </th>
            <th style="width: 15px; background-color: #f5f242;">Delivery Status </th>
            <th style="width: 20px; background-color: #f5f242;"> Package Name </th>
            <th style="width: 15px; background-color: #f5f242;"> Package Size </th>
            <th style="width: 25px; background-color: #f5f242;">Remark</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shoppers as $shopper)
            <tr>
                <td>{{ $shopper->date }}</td>
                <td>{{ $shopper->receiver_name }}</td>
                <td>{{ $shopper->phone }}</td>
                <td>{{ $shopper->address }}</td>
                <td>{{ $shopper->name }}</td>            {{-- show township name --}}
                <td>{{ $shopper->price }}</td>
                <td>{{ $shopper->delivery_fee }}</td>
                <td>{{ $shopper->deposit_amount }}</td>
                <td>{{ $shopper->driver_name }}</td>
                <td>{{ $shopper->payment_status }}</td>
                <td>{{ $shopper->status }}</td>
                <td>{{ $shopper->package_name }}</td>
                <td >{{ $shopper->package_size }}</td>
                <td>{{ $shopper->remark }}</td>
            </tr>
        @endforeach
    </tbody>
</table>