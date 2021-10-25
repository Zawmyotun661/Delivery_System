

@extends('dashboardTemplate')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-10">
            <div class="row mb-3">
                <div class="col-md-6 mx-auto">
                        <div class="input-group" id="myDiv">
                            <input class="form-control border-end-0 border" type="search" id="name" placeholder="Search By Customer Name or Township or Status" value="">
                            <span class="input-group-append">
                                <button class="btn btn-outline-secondary bg-white border-start-0 border ms-n5" id="search">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                </div>
            </div>
            <div>
            <a href="{{url('/driver_dashboard')}}">
                    <button class="btn btn-primary btn-sm  mb-2">
                        <i class="fa  fa-truck-pickup"></i> New
                    </button>
                </a>
            </div>
        <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th class="px-3">Driver Name</th>
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
                    <tbody id="table_body">
                        
                        @foreach($packages as $package)
                        @if($package->id==Auth::user()->id)
                        @if($package->status=='Processing')
                        <tr>
                    
                            <td>{{ $package -> 	driver_name }}</td>
                            <td >{{ $package -> date }}</td>
                            <td>{{ $package -> 	receiver_name }}</td>
                            <td>{{ $package -> phone }}</td>
                            <td>{{ $package -> address }}</td>
                            <td>{{ $package -> name }}</td>
                            <td>{{ $package -> price }}</td>
                            
                            <td>{{ $package -> delivery_fee }}</td>
                            <td>{{ $package -> status }}</td>
                            <td>
                            <a href="{{url('driver_dashboard/'.$package->id.'/edit')}}">
                                <button type="button" class="btn btn-warning btn-sm">
                                <i class="fas fa-truck-pickup"  style="font-size: 1.5rem;" ></i> <strong>Pick Up</strong></button>
                            </a>
                            </td>
                        </tr>
                        @endif
                        @endif
                     @endforeach
                    
                    </tbody>
                </table>
        </div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript">
$(document).ready(function(){
    var search_value = document.getElementById('name').value;
    // if(search_value != ''){
    //     alert('a');
    // }
    $('#search').on('click', function(){
        var query = $('#name').val();
        // var status = $('#status').val();
        var tableBody = document.getElementById('table_body');
        tableBody.innerHTML = '';
        $.ajax({
            url:'{{route('package_list')}}',
            type:'GET',
            data:{'word':query},
            success:function(data) {
                console.log(data)
                data.forEach(item => {
                if(item.online_shop_name == null){
                    item.online_shop_name = '';
                }
                if(item.to_get == null){
                    item.to_get = '';
                }
                if(item.remark == null){
                    item.remark = '';
                }
                if(item.status=='Processing'){
                tableBody.innerHTML += 
                '<tr>'+
                '<td>'+item.date+'</td>'+
                '<td>'+item.receiver_name+'</td>'+
                '<td>'+item.phone+'</td>'+
                '<td>'+item.address+'</td>'+
                '<td>'+item.name+'</td>'+
                '<td>'+item.price+'</td>'+
              
                '<td>'+item.delivery_fee+'</td>'+
        

                '<td>'+item.status+'</td>'+
        
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
        window.location.href = id+'/edit';
        var container = document.getElementById('myDiv');
        var content = container.innerHTML;
        container.innerHTML = content;
        console.log('refreshed');        
    }
</script>
@endsection
