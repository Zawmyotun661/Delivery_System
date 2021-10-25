

@extends('dashboardTemplate')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-10">
            <div class="row mb-3">
                <div class="col-md-6 mx-auto">
                        <div class="input-group" id="myDiv">
                            <input class="form-control border-end-0 border" type="search" id="name" placeholder="Search By Receiver Name or Township or Status" value="">
                            <span class="input-group-append">
                                <button class="btn btn-outline-secondary bg-white border-start-0 border ms-n5" id="search">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                </div>
            </div>
            @if(Session('successAlert'))
                <div class="alert alert-success alert-dismissible show fade">
                    <strong>{{Session('successAlert')}}</strong>
                    <button class="close" data-dismiss="alert">&times;</button>
                </div>
                @endif
            <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#new" data-toggle="tab"><i class="fa  fa-truck-pickup"></i>New</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#profile" data-toggle="tab"><i class="fa  fa-truck-pickup"></i>Processing</a>
                </li>
              </ul>
              <div id='content' class="tab-content">
                <div class="tab-pane active" id="new">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="px-5"> Date </th>
                            <th class="px-3">Receiver Name</th>
                            <th >Receiver Phone Number</th>
                            <th class="px-5">Address</th>
                            <th class="px-3">Township </th>
                            <th class="px-3">Amount </th>
                            
                            <th class="px-3">Delivery Fee </th>
                         
                            <th class="px-3">Delivery Status </th>
                       
                            <th  class="px-5">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="new_table">
                  
                        @foreach($packages as $package)
                        @if($package->status=='New')
                        <tr>
                            <td >{{ $package -> date }}</td>
                            <td>{{ $package -> 	receiver_name }}</td>
                            <td>{{ $package -> phone }}</td>
                            <td>{{ $package -> address }}</td>
                            <td>{{ $package -> name }}</td>
                            <td>{{ $package -> price }}</td>
                            
                            <td>{{ $package -> delivery_fee }}</td>
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
                            @if($package->status=="Error")
                            <td class="text-danger"><strong>{{ $package -> status }}</strong></td>
                            @endif
                            <td>
                            <a href="{{url('driver_dashboard/'.$package->id.'/edit')}}">
                                <button type="button" class="btn btn-warning btn-sm">
                                <i class="fas fa-truck-pickup"  style="font-size: 1.5rem;" ></i> <strong>Pick Up</strong></button>
                            </a>
                            </td>
                        </tr>
                        @endif
                     @endforeach
                    
                    </tbody>
                </table>
                </div>
                <div class="tab-pane" id="profile">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                {{-- <th>ID</th> --}}
                                <th class="px-5"> Date </th>
                                <th class="px-3"> Driver Name </th>
                                <th class="px-3">Receiver Name</th>
                                <th >Receiver Phone Number</th>
                                <th class="px-5">Address</th>
                                <th class="px-3">Township </th>
                                <th class="px-3">Amount </th>
                                
                                <th class="px-3">Delivery Fee </th>
                                
                                <th class="px-3">Delivery Status </th>
                            
                                <th  class="px-5">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="processing_table">
                            @foreach($packages as $package)
                            @if($package->status=='Processing' && $package->driver_id == Auth::user()->id)
                            <tr>
                                <td >{{ $package -> date }}</td>
                                <td >{{ $package -> driver_name }}</td>
                                <td>{{ $package -> 	receiver_name }}</td>
                                <td>{{ $package -> phone }}</td>
                                <td>{{ $package -> address }}</td>
                                <td>{{ $package -> name }}</td>
                                <td>{{ $package -> price }}</td>
                                <td>{{ $package -> delivery_fee }}</td>
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
                                @if($package->status=="Error")
                                <td class="text-danger"><strong>{{ $package -> status }}</strong></td>
                                @endif
                                <td>
                                <a href="{{url('driver_dashboard/'.$package->id.'/edit')}}">
                                    <button type="button" class="btn btn-warning btn-sm">
                                    <i class="fas fa-truck-pickup"  style="font-size: 1.5rem;" ></i> <strong>Pick Up</strong></button>
                                </a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript">
$(document).ready(function(){
    var search_value = document.getElementById('name').value;
    $('#search').on('click', function(){
        var query = $('#name').val();
        var newTable = document.getElementById('new_table');
        var processingTable = document.getElementById('processing_table');
        newTable.innerHTML = '';
        processingTable.innerHTML = '';
        var driverId = {{Auth::user()->id}}
        $.ajax({
            url:'{{route('package_list')}}',
            type:'GET',
            data:{'word':query},
            success:function(data) {
                data.forEach(item => {
                if(item.status=='New'){
                newTable.innerHTML += 
                '<tr>'+
                '<td>'+item.date+'</td>'+
                '<td>'+item.receiver_name+'</td>'+
                '<td>'+item.phone+'</td>'+
                '<td>'+item.address+'</td>'+
                '<td>'+item.name+'</td>'+
                '<td>'+item.price+'</td>'+
                '<td>'+item.delivery_fee+'</td>'+
                '<td class="text-primary"><strong>'+item.status+'</strong></td>'+
                '<td><button type="button" class="btn btn-warning btn-sm" onclick="pickUpFunc('+item.id+')">'+
                '<i class="fas fa-truck-pickup"  style="font-size: 1.5rem;" ></i> <strong>Pick Up</strong></button></td>'+
                '</tr>';
                }else if(item.status == 'Processing' && item.driver_id == driverId){
                    processingTable.innerHTML += 
                '<tr>'+
                '<td>'+item.date+'</td>'+
                '<td>'+item.driver_name+'</td>'+
                '<td>'+item.receiver_name+'</td>'+
                '<td>'+item.phone+'</td>'+
                '<td>'+item.address+'</td>'+
                '<td>'+item.name+'</td>'+
                '<td>'+item.price+'</td>'+
                '<td>'+item.delivery_fee+'</td>'+
                '<td class="text-warning"><strong>'+item.status+'</strong</td>'+
                '<td><button type="button" class="btn btn-warning btn-sm" onclick="pickUpFunc('+item.id+')">'+
                '<i class="fas fa-truck-pickup"  style="font-size: 1.5rem;" ></i> <strong>Pick Up</strong></button></td>'+
                '</tr>';
                }
                })
            }
        })
    }); 
});
//pick up function
function pickUpFunc(id) {
        window.location.href = 'driver_dashboard/'+id+'/edit';
        var container = document.getElementById('myDiv');
        var content = container.innerHTML;
        container.innerHTML = content;
        console.log('refreshed');        
    }
</script>
@endsection
