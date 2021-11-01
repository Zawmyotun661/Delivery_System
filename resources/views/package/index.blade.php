@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
          <div class="col-md-2"></div>
            <div class="col-md-10">
            <h5>Package Lists</h5>
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
                            <option value="Pickup">Pick Up</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Error">Error</option>
                        </select>
                    </div>
                    <br>
                    @if (!$isShopper)
                    <div class="col-md-6 mx-auto">
                            <div class="input-group" id="myDiv">
                                <input class="form-control border" type="search" id="name" placeholder="Filter by Driver Name or Township" value="" style="border-radius: 3px;">
                                <div class="pl-4">
                                    <button class="btn btn-primary border px-2" id="search" style="width: 130px; padding:10px;">
                                        <i class="fa fa-search">Search</i>
                                    </button>
                                </div>
                            </div>
                    </div>
                    @else
                    <div class="col-md-6 mx-auto">
                        <div class="input-group" id="myDiv">
                            <input class="form-control border" type="search" id="name" placeholder="Filter by Township" value="" style="border-radius: 3px;">
                            <div class="pl-4">
                                <button class="btn btn-primary border px-2" id="search" style="width: 130px; padding:10px;">
                                    <i class="fa fa-search">Search</i>
                                </button>
                            </div>
                        </div>
                </div>
                    @endif
                </div>
                @if (!$isShopper)
                <div id="download_package">
                    <a href="{{url('export')}}">
                        <button class="btn btn-success btn-sm  mb-2">
                            <i class="fas fa-file-download"></i>  Download Excel
                        </button>
                    </a>
                </div>
                @else
                @if($new_pack == 1)
                <a href="{{url('shoppers/'.$id.'/new-package')}}" style="text-decoration: none;">
                    <button class="btn btn-primary btn-sm  mb-2">
                        <i class="fa fa-plus-circle"></i> Add New
                    </button>
                </a>
                @else
                    <button class="btn btn-primary btn-sm  mb-2" id="no-new">
                        <i class="fa fa-plus-circle"></i> Add New
                    </button>
                @endif
                <div id="shopper_download">
                    <a href="{{url('shoppers/'.$id.'/export')}}" style="text-decoration: none;">
                        <button class="btn btn-success btn-sm  mb-2">
                            <i class="fas fa-file-download"></i>  Download Excel
                        </button>
                    </a>
                    <a href="{{url('shopperspdf/'.$id.'/export')}}">
                        <button class="btn btn-success btn-sm  mb-2">
                            <i class="fas fa-file-download"></i>  Download PDF
                        </button>
                    </a>
                </div>
                @endif
                @if(Session('successAlert'))
                <div class="alert alert-success alert-dismissible show fade">
                    <strong>{{Session('successAlert')}}</strong>
                    <button class="close" data-dismiss="alert">&times;</button>
                </div>
                @endif
                    <div class="alert alert-success alert-dismissible show fade" id="updateAlert">
                        <strong>You Have Successfully Updated!</strong>
                        <button class="close" data-dismiss="alert">&times;</button>
                    </div>
                
                <table class="table table-bordered table-hover" data-show-footer="true">
                    <thead>
                        <tr>
                            <th class="px-5"> Date </th>
                            <th class="px-3">Receiver Name</th>
                            <th class="px-5">Receiver Phone Number </th>
                            <th class="px-5">Receiver Address</th>
                            <th class="px-3">Township </th>
                            <th class="px-3">Amount </th>
                            <th class="px-3">Delivery Fee </th>
                            <th class="px-3">Deposit</th>
                            @if (!$isShopper)
                            <th class="px-3">Driver Name </th>
                            <th class="px-3">Payment Status </th>
                            @endif
                            <th class="px-3">Delivery Status </th>
                            <th class="px-3"> Package Name </th>
                            <th> Package Size </th>
                            <th class="px-3">Remark</th>
                            @if ($isShopper)
                            <th class="px-5">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        @foreach($packages as $package)
                        <tr>
                            <td >{{ $package -> date }}</td>
                            <td>{{ $package-> receiver_name }}</td>
                            <td>{{ $package -> phone }}</td>
                            <td>{{ $package -> address }}</td>
                            <td>{{ $package -> name }}</td>            {{-- show township name --}}
                            <td>{{ $package -> price }}</td>
                            <td>{{ $package -> delivery_fee }}</td>
                            <td>{{ $package -> deposit_amount }}</td>
                            @if (!$isShopper)
                            <td>{{ $package -> driver_name}}</td>
                            <td>{{ $package -> payment_status}}</td>
                            @endif
                            @if($package->status=="New")
                            <td class="text-primary"><strong>{{ $package -> status }}</strong></td>
                            @endif
                            @if($package->status=="Processing")
                            <td class="text-warning"><strong>{{ $package -> status }}</strong></td>
                            @endif
                            @if($package->status=="Paid")
                            <td class="text-success"><strong>{{ $package -> status }}</strong></td>
                            @endif
                            @if($package->status=="Delivered")
                            <td class="text-success"><strong>{{ $package -> status }}</strong></td>
                            @endif
                            @if($package->status=="Pickup")
                            <td style=" color:#ad5389"><strong>{{ $package -> status }}</strong></td>
                            @endif
                            @if($package->status=="Error")
                            <td class="text-danger"><strong>{{ $package -> status }}</strong></td>
                            @endif
                            <td >{{ $package -> package_name }}</td>
                            <td >{{ $package -> package_size }}</td>
                            {{-- <td>{{ $package -> status }}</td> --}}
                            <td>{{ $package -> remark }}</td>
                            @if ($isShopper)
                            <td>
                                <a href="{{url('shoppers/'.$id.'/'.'package/'.$package->id.'/edit')}}" style="text-decoration: none;">
                                <button type="button" class="btn btn-success btn-sm">
                                    <i class="fa fa-edit"></i> </button>
                                </a>
                                {{-- <a href="{{url('shoppers/'.$id.'/'.'package/'.$package->id.'/destroy')}}"> --}}
                                <button type="submit" class="btn btn-danger btn-sm" onclick="deleteFunction({{$package->id}})"> 
                                    <i class="fa fa-trash"></i></button>
                                {{-- </a> --}}
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot id="table_footer">
                    @if ($isShopper)
                        <tr>
                            <th>Total Amount</th>
                            <th colspan="12">{{$total}}</th>
                        </tr>
                        <tr>
                            <th>Total Delivery Fee</th>
                            <th colspan="12">{{$total_delivery}}</th>
                        </tr>
                        <tr>
                            <th>Payable Amount</th>
                            <th colspan="12">{{$toget}}</th>
                        </tr>
                    @endif
                    </tfoot>
                </table>
                
                {{-- {{$packages->links()}} --}}
            </div>
         
        </div>
    </div>

@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript">
$(document).ready(function(){
    $('#search').on('click', function(){
        var query = '';
         query = $('#name').val();
        var date = '';
         date = $('#date').val();
         var status = '';
         status = $('#status').val();
        //  var deposit_amount = '';
        var tableBody = document.getElementById('table_body');
        tableBody.innerHTML = '';
        var tableFooter = document.getElementById('table_footer');
        tableFooter.innerHTML = '';
        $.ajax({
            url:'{{route('search_package')}}',
            type:'GET',
            data:{'word':query, 'searchDate':date, 'status':status, 'isShopper':{{$isShopper}}, 'shopperId': {{$id ?? ''}}},
            success:function(data) {
                console.log(data)
                var package = data.package;
                package.forEach(item => {
                var status_color = '';
                if(item.remark == null){
                    item.remark = '';
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
                if({{$isShopper}} == 1){
                    tableBody.innerHTML += 
                    '<tr>'+
                    '<td>'+item.date+'</td>'+
                    '<td>'+item.receiver_name+'</td>'+
                    '<td>'+item.phone+'</td>'+
                    '<td>'+item.address+'</td>'+
                    '<td>'+item.name+'</td>'+
                    '<td>'+item.price+'</td>'+
                    '<td>'+item.delivery_fee+'</td>'+
                    '<td>'+item.deposit_amount+'</td>'+
                    status_color
                    // '<td>'+item.status+'</td>'+
                    +'<td>'+item.package_name+'</td>'+
                    '<td>'+item.package_size+'</td>'+
                    '<td>'+item.remark+'</td>'+
                    '<td><button type="button" class="btn btn-success btn-sm" onclick="editFunction('+item.id+')">'+
                    '<i class="fa fa-edit"></i></button>'+
                    '<button clas class="btn btn-danger btn-sm ml-2" onclick="deleteFunction('+item.id+')"> <i class="fa fa-trash"></i></button></td>'+
                    '</tr>';
                }else {
                    if(item.driver_name == null){
                        item.driver_name = '';
                    }
                    if(item.payment_status == null){
                        item.payment_status = '';
                    }
                    tableBody.innerHTML += 
                    '<tr>'+
                    '<td>'+item.date+'</td>'+
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
                    '</tr>';
                } 
                })
                if({{$isShopper}} == 1){
                    var shopper_download = document.getElementById('shopper_download');
                    shopper_download.innerHTML = '';
                    shopper_download.innerHTML +=
                    '<button class="btn btn-success btn-sm  mb-2" onclick="excelDownload()"><i class="fas fa-file-download"></i>  Download Excel</button>'+
                    '<button class="btn btn-success btn-sm  mb-2 ms-1" onclick="pdfDownload()"><i class="fas fa-file-download"></i>  Download PDF</button>';
                    tableFooter.innerHTML +=
                        '<tr>'+
                        '<th>Total Amount</th>'+
                        '<th colspan="12">'+data.total+'</th>'+
                        '</tr>'+
                        '<tr>'+
                        '<th>Total Delivery Fee</th>'+
                        '<th colspan="12">'+data.total_delivery+'</th>'+
                        '</tr>'+
                        '<tr>'+
                        '<th>Payable Amount</th>'+
                        '<th colspan="12">'+data.payable+'</th>'+
                        '</tr>';
                }else {
                    var download_pack = document.getElementById('download_package');
                    download_pack.innerHTML = '';
                    download_pack.innerHTML +=
                    '<button class="btn btn-success btn-sm  mb-2" onclick="packageDownload()"><i class="fas fa-file-download"></i>  Download Excel</button>';
                }
            }
        })
    }); 
});

function editFunction(id) 
{
    var shopperId = {{$id ?? ''}};
        window.location.href = 'package/'+id+'/edit';
        var container = document.getElementById('myDiv');
        var content = container.innerHTML;
        container.innerHTML = content;
}

function deleteFunction(id) 
{
    // alert(id);
    event.preventDefault();
    swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        confirmButtonColor: '#eea025',
        cancelButtonColor: '#b1abab',
    }).then((result) => {
        if(result.isConfirmed){
            window.location.href = 'package/'+id+'/destroy';
        }
    })
}
function packageDownload()
{
    var name = '';
    var date = '';
    var status = '';
    name = document.getElementById('name').value;
    date = document.getElementById('date').value;
    status = document.getElementById('status').value;
    var data = {date,name,status};
    var params = new URLSearchParams(data);
    var url = 'export/'+params;
    window.location = url;
}
function excelDownload()
{
    var name = '';
    var date = '';
    var status = '';
    name = document.getElementById('name').value;
    date = document.getElementById('date').value;
    status = document.getElementById('status').value;
    var data = {date,name,status};
    var params = new URLSearchParams(data);
    var url = 'excel-export/'+params;
    window.location = url;
}
function pdfDownload()
{
    var name = '';
    var date = '';
    var status = '';
    name = document.getElementById('name').value;
    date = document.getElementById('date').value;
    status = document.getElementById('status').value;
    var data = {date,name,status};
    var params = new URLSearchParams(data);
    var url = 'pdf-export/'+params;
    window.location = url;
    // window.location.href = 'pdf-export/'+date+'/'+name;
}
$(document).ready(function () {
    // $('#updateAlert').hide();
if({{$isShopper}} == 1){
    var session = '';
     session = sessionStorage.getItem('successAlert');
    if(session){
        $('#updateAlert').show();
        sessionStorage.setItem('successAlert','');
    }else {
        $('#updateAlert').hide();
    }
    if({{$new_pack}} == 0) {
            document.getElementById("no-new").addEventListener('click', function(){
                Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'You have reached your maximum limit of creating packages allowed!',
                footer: 'Please contact to <a href="">Deliburma.com</a>'
                })
            });
        }   
    }else {
        var session = '';
     session = sessionStorage.getItem('successAlert');
    if(session){
        $('#updateAlert').show();
        sessionStorage.setItem('successAlert','');
    }else {
        $('#updateAlert').hide();
    }
    }
});
</script>