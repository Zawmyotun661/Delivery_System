<table>
    <thead>
        <tr>
            <th style="width: 15px; background-color: #f5f242;"> Date </th>
            <th style="width: 20px; background-color: #f5f242;"> Client Name </th>
            <th style="width: 20px; background-color: #f5f242;"> Customer Name </th>
            <th style="width: 20px; background-color: #f5f242;"> Package Name </th>
            <th style="width: 15px; background-color: #f5f242;"> Package Size </th>
            <th style="width: 30px; background-color: #f5f242;">Receiver Name</th>
            <th style="width: 25px; background-color: #f5f242;">Receiver Phone Number </th>
            <th style="width: 50px; background-color: #f5f242;">Receiver Address</th>
            <th style="width: 20px; background-color: #f5f242;">Township </th>
            <th style="width: 15px; background-color: #f5f242;">Amount </th>
            <th style="width: 15px; background-color: #f5f242;">Delivery Fee </th>
            <th style="width: 15px; background-color: #f5f242;">Deposit</th>
            <th style="width: 15px; background-color: #f5f242;">Driver Name</th>
            <th style="width: 15px; background-color: #f5f242;">Delivery Status </th>
            <th style="width: 15px; background-color: #f5f242;">Payment Status </th>
            <th style="width: 25px; background-color: #f5f242;">Remark</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            <tr>
                <td>{{ $report->date }}</td>
                <td>{{ $report->client_name }}</td>
                <td>{{ $report->cus_name }}</td>
                <td>{{ $report->package_name }}</td>
                <td >{{ $report->package_size }}</td>
                <td>{{ $report->receiver_name }}</td>
                <td>{{ $report->phone }}</td>
                <td>{{ $report->address }}</td>
                <td>{{ $report->name }}</td>            {{-- show township name --}}
                <td>{{ $report->price }}</td>
                <td>{{ $report->delivery_fee }}</td>
                <td>{{ $report->deposit_amount }}</td>
                <td>{{ $report->driver_name }}</td>
                <td>{{ $report->status }}</td>
                <td>{{ $report->payment_status }}</td>
                <td>{{ $report->remark }}</td>
            </tr>
        @endforeach
    </tbody>
</table>