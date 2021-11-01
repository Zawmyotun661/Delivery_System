@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
          <div class="col-md-2"></div>
            <div class="col-md-10">
            <h5>Report Lists</h5>
                <div class="row mb-3 mt-5">
                    <label for="date"> Filter by Date</label>
                    <div class="form-group col-md-3">
                        <input type="date" name="date" class="form-control"  placeholder="Enter Date" id="date">
                    </div>
                    <div class="form-group col-md-3">
                        <select  class="form-select" aria-label="Default select example" name="status" id="status">
                            <option value="">Filter by Delivery Status</option>
                            <option value="New">New</option>
                            <option value="Paid">Paid</option>
                            <option value="Processing">Processing</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Pickup">Pick Up</option>
                            <option value="Error">Error</option>
                        </select>
                    </div>
                    <br>
                    <div class="col-md-6 mx-auto">
                    <div class="input-group" id="myDiv">
                        <input class="form-control border" type="search" id="name"
                            placeholder="Filter by Client or Driver Name or Township" value="" style="border-radius: 3px;">
                        
                        <div class="pl-5">
                            <button class="btn btn-primary border px-2" id="search" 
                            style="width: 130px; padding:10px; border-radius:20px">
                                <i class="fa fa-search">  Search</i>
                            </button>
                        </div>
                    </div>
                    </div>
                </div>
                <div id="download_report">
                    <a href="{{url('/reports-export')}}">
                        <button class="btn btn-success btn-sm  mb-2">
                            <i class="fas fa-file-download"></i>  Download Excel
                        </button>
                    </a>
                </div>
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="px-5"> Date </th>
                            <th class="px-3">Client Name</th>
                            <th class="px-3">Customer Name</th>
                            <th class="px-3">Receiver Name</th>
                            <th class="px-5">Receiver Phone </th>
                            <th class="px-5">Receiver Address</th>
                            <th class="px-3">Township </th>
                            <th class="px-3">Amount </th>
                            <th class="px-3">Delivery Fee </th>
                            <th class="px-3">Deposit</th>
                            <th class="px-3">Driver Name</th>
                            <th class="px-3">Payment Status </th>
                            <th class="px-3">Delivery Status </th>
                            <th class="px-3">Package Name</th>
                            <th class="px-3">Package Size</th>
                            <th class="px-3">Remark</th>
                            <th >Receipt</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        @foreach($reports as $report)
                        <tr>
                            <td >{{ $report -> date }}</td>
                            <td>{{ $report->client_name }}</td>
                            <td>{{ $report->cus_name }}</td>
                            <td >{{ $report -> receiver_name }}</td>
                            <td>{{ $report -> phone }}</td>
                            <td>{{ $report -> address }}</td>
                            <td>{{ $report -> name }}</td>            {{-- show township name --}}
                            <td>{{ $report -> price }}</td>
                            <td>{{ $report -> delivery_fee }}</td>
                            <td>{{ $report->deposit_amount }}</td>
                            <td>{{ $report -> driver_name }}</td>
                            <td>{{ $report -> payment_status }}</td>
                            @if($report->status=="New")
                            <td class="text-primary"><strong>{{ $report -> status }}</strong></td>
                            @endif
                            @if($report->status=="Processing")
                            <td class="text-warning"><strong>{{ $report -> status }}</strong></td>
                            @endif
                            @if($report->status=="Paid")
                            <td class="text-success"><strong>{{ $report -> status }}</strong></td>
                            @endif
                            @if($report->status=="Delivered")
                            <td class="text-success"><strong>{{ $report -> status }}</strong></td>
                            @endif
                            @if($report->status=="Pickup")
                            <td style=" color:#ad5389"><strong>{{ $report -> status }}</strong></td>
                            @endif
                            @if($report->status=="Error")
                            <td class="text-danger"><strong>{{ $report -> status }}</strong></td>
                            @endif
                            <td >{{ $report -> package_name }}</td>
                            <td>{{ $report -> package_size }}</td>
                            <td>{{ $report -> remark }}</td>
                            @if( $report->image)
                            <td> <img src="{{ asset('image/'. $report->image) }}" style="width: 100px; height:100px;"></a></td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- {{$packages->links()}} --}}
            </div>
         
        </div>
    </div>

@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript">
$(document).ready(function(){
    var search_value = document.getElementById('name').value;
    $('#search').on('click', function(){
        var query = '';
         query = $('#name').val();
        var date = '';
         date = $('#date').val();
        var status = '';
         status = $('#status').val();
        var tableBody = document.getElementById('table_body');
        tableBody.innerHTML = '';
        var download_report = document.getElementById('download_report');
        download_report.innerHTML = '';
        $.ajax({
            url:'{{route('search_report')}}',
            type:'GET',
            data:{'word':query, 'searchDate':date, 'status':status},
            success:function(data) {
                data.forEach(item => {
                    var status_color = '';
                if(item.payment_status == null){
                    item.payment_status = '';
                }
                if(item.image == null){
                    item.image = '';
                }
                if(item.remark == null){
                    item.remark = '';
                }
                if(item.driver_name == null){
                    item.driver_name = '';
                }
                if(item.status == 'New'){
                    status_color = '<td class="text-primary"><strong>'+item.status+'</strong></td>'
                }
                if(item.status == 'Paid' || item.status == 'Delivered'){
                    status_color = '<td class="text-success"><strong>'+item.status+'</strong></td>'
                }
                if(item.status == 'Processing'){
                    status_color = '<td class="text-warning"><strong>'+item.status+'</strong></td>'
                }
                if(item.status == 'Pickup'){
                    status_color = '<td style=" color:#ad5389"><strong>'+item.status+'</strong></td>'
                }
                if(item.status == 'Error'){
                    status_color = '<td class="text-danger"><strong>'+item.status+'</strong></td>'
                }
                tableBody.innerHTML += 
                '<tr>'+
                '<td>'+item.date+'</td>'+
                '<td>'+item.client_name+'</td>'+
                '<td>'+item.cus_name+'</td>'+
                '<td>'+item.receiver_name+'</td>'+
                '<td>'+item.phone+'</td>'+
                '<td>'+item.address+'</td>'+
                '<td>'+item.name+'</td>'+
                '<td>'+item.price+'</td>'+
                '<td>'+item.delivery_fee+'</td>'+
                '<td>'+item.deposit_amount+'</td>'+
                '<td>'+item.driver_name+'</td>'+
                '<td>'+item.payment_status+'</td>'+
                status_color
                +'<td>'+item.package_name+'</td>'+
                '<td>'+item.package_size+'</td>'+
                '<td>'+item.remark+'</td>'+
                '<td>'+item.image+'</td>'+
                '</tr>';
                })
                download_report.innerHTML += 
                '<button class="btn btn-success btn-sm  mb-2" onclick="searchDownload()"><i class="fas fa-file-download"></i>  Download Excel</button>';
            }
        })
    }); 
});

function searchDownload() 
{
    var name = '';
    var date = '';
    var status = '';
    name = document.getElementById('name').value;
    date = document.getElementById('date').value;
    status = document.getElementById('status').value;
    var data = {date,name,status};
    var params = new URLSearchParams(data);
    var url = 'reports-export/'+params;
    window.location = url;
}
</script>