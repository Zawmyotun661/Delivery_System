<table>
    <thead>
        <tr>
            <th style="background-color: #f5f242;"> Date </th>
            <th style="background-color: #f5f242;"> Package Name </th>
            <th style="background-color: #f5f242;"> Package Size </th>
            <th style="background-color: #f5f242;">Receiver Name</th>
            <th style="background-color: #f5f242;">Receiver Phone Number </th>
            <th style="background-color: #f5f242;">Receiver Address</th>
            <th style="background-color: #f5f242;">Township </th>
            <th style="background-color: #f5f242;">Amount </th>
            <th style="background-color: #f5f242;">Delivery Fee </th>
            <th style="background-color: #f5f242;">Deposit</th>
            <th style="background-color: #f5f242;">Delivery Status </th>
            <th style="background-color: #f5f242;">Payment Status </th>
            <th style="background-color: #f5f242;">Remark</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($shoppers as $shopper)
            <tr>
                <td>{{ $shopper->date }}</td>
                <td>{{ $shopper->package_name }}</td>
                <td >{{ $shopper->package_size }}</td>
                <td>{{ $shopper->receiver_name }}</td>
                <td>{{ $shopper->phone }}</td>
                <td>{{ $shopper->address }}</td>
                <td>{{ $shopper->name }}</td>            {{-- show township name --}}
                <td>{{ $shopper->price }}</td>
                <td>{{ $shopper->delivery_fee }}</td>
                <td>{{ $shopper->deposit_amount }}</td>
                <td>{{ $shopper->status }}</td>
                <td>{{ $shopper->payment_status }}</td>
                <td>{{ $shopper->remark }}</td>
            </tr>
        @endforeach
            <tr></tr>
            <tr>
                <th style="background-color: #42f5c2"><strong>Total Amount</strong></th>
                <th><strong>{{$total_price}}</strong></th>
            </tr>
            <tr>
                <th style="background-color: #42f5c2"><strong>Total Delivery</strong></th>
                <th><strong>{{$total_delivery}}</strong></th>
            </tr>
            <tr>
                <th style="background-color: #42f5c2"><strong>Paid Delivery(OS)</strong></th>
                <th><strong>{{$amount_delivery}}</strong></th>
            </tr>
            <tr>
                <th style="background-color: #42f5c2"><strong>Final Amount</strong></th>
                <th><strong>{{$final_amount}}</strong></th>
            </tr>
            <tr>
                <th style="background-color: #42f5c2"><strong>Payable Amount</strong></th>
                <th><strong>{{$final_deposit}}</strong></th>
            </tr>
           
    </tbody>
</table>