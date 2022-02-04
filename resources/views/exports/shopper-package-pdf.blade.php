<!DOCTYPE html>
<html>
<head>
</head>
<body>
    {{-- <div class="main-div"> --}}
    <h2 style="text-align: center;">Invoice</h2>
    <br>
    <div class="shopper">
        <label>Customer Name : </label> {{$shopper->name}}
        <br>
        <label>Customer Address : </label> {{$shopper->address}}
        <br>
        <label>Customer Phone Number : </label> {{$shopper->phone}}
    </div>
    <div class="package">
        <table class="package-table">
            <thead>
                <tr class="thead">
                    <th>Date</th>
                    <th>Package Name</th>
                    <th>Package Size</th>
                    <th>Receiver Name</th>
                    <th>Receiver Phone</th>
                    <th>Receiver Address</th>
                    <th>Township</th>
                    <th>Amount</th>
                    <th>Delivery Fee</th>
                    <th>Deposit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($packages as $package)
                <tr class="border-tr">
                  <td>{{ $package->date }}</td>  
                  <td>{{ $package->package_name }}</td>
                  <td>{{ $package->package_size }}</td>
                  <td>{{ $package->receiver_name }}</td>
                  <td>{{ $package->phone }}</td>
                  <td>{{ $package->address }}</td>
                  <td>{{ $package->name }}</td>
                  <td>{{ $package->price }}</td>
                  <td>{{ $package->delivery_fee }}</td>
                  <td>{{ $package->deposit_amount }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <br>
        <div>
        <table class="amount-table">
            <tbody>
                <tr>
                    <td>Total Amount : </td>
                    <td style="font-weight: bold;">{{$total_amount}}<div class="div-border"></div></td>
                    
                </tr>
                <tr>
                    <td>Final Amount : </td>
                    <td style="font-weight: bold;">{{$toget}}<div class="div-border"></div></td>
                    
                </tr>
             
            </tbody>
        </table>
    </div>
    </div>
    <div class="sub-div">
        <div class="div-border"></div>
        <div class="p-align">
        <p>Deliburma.Co.Ltd</p>
    </div>
    </div>
{{-- </div> --}}
</body>
<style>
    .shopper{
        width: 47%;
        height: 8%;
        border: 1px ridge #e5a5be;
        display: inline-block;
        padding: 8px;
    }
    .thead {
        background-color: #e5a5be;
    }
    .package-table {
        border-collapse: collapse;
    }
    .package-table td{
        border: 1px ridge #a1999c;
        border-left: none;
        border-right: none;
        margin-left: 3px;
    }
    .amount-table {
        float: right;
    }
    .div-border {
        border: 1px ridge #e5a5be;
    }
    .main-div {
        position: relative;
        border: 2px ridge #e5a5be;
        padding: 4px;
        /* height: 100%;
        width: 100%; */
    }
    .sub-div {
        position: absolute;
        bottom: 0px;
    }
    .p-align {
        margin-left: 300px;
        margin-top: 5px;
    }
</style>
</html>