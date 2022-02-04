

@extends('dashboardTemplate')

@section('content')
<style> 
.card h6 {
    line-height: 2;
   
}
#nav{
    height: 100%;
    display: inline-flex;
    flex-direction: row;
  
 
}
.active {
color: black;
}
.l-bg-blue-dark {
    /* background:linear-gradient(to right, rgb(70 95 112), rgb(44, 62, 80)); */
    background: linear-gradient(to right, rgb(15, 32, 39), rgb(32, 58, 67), rgb(44, 83, 100)) !important;
    color: white;
}

</style>
<div class="container mt-5">
    <div class="row">
    <div class="col-md-2"></div>
        <div class="col-md-10">
            <div class="row mb-3">
               
              
               
            <label for="date"> Filter by Date</label>
            <div class="form-group col-md-3">
                <input type="date" name="date" class="form-control p-1"  placeholder="Enter Date" id="date">
            </div>
            <div class="form-group col-md-3">
                        <select  class="form-select" aria-label="Default select example"  id="township_name">
                            <option value="">Filter by Township </option>
                            @foreach($township as $town)
                            <option value="{{$town->name}}">{{$town->name}}</option>
                          @endforeach
                        </select>
                    </div>
            <div class="col-md-6 mx-auto">
                    <div class="input-group" id="myDiv">
                        <input class="form-control border" type="search" id="name"
                            placeholder="Filter by Receiver & Phone " value="" style="border-radius: 3px;">
                        
                        <div class="pl-5">
                            <button class="btn btn-primary border px-2" id="search" 
                            style="width: 130px; padding:10px; border-radius:20px">
                                <i class="fa fa-search">  Search</i>
                            </button>
                        </div>
                    </div>
                    </div>
            </div>
            @if(Session('successAlert'))
                <div class="alert alert-success alert-dismissible show fade">
                    <strong>{{Session('successAlert')}}</strong>
                    <button class="close" data-dismiss="alert">&times;</button>
                </div>
                @endif
                <div>
            <ul class="nav nav-tabs" id="nav">
                <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="#new" data-toggle="tab"><i class="fa  fa-truck-pickup"></i>New</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#profile" data-toggle="tab"><i class="fa  fa-truck-pickup"></i>Processing</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#delivered" data-toggle="tab"><i class="fa  fa-truck-pickup"></i>Delivered</a>
                </li>
              </ul>
                </div>
              <div id='content' class="tab-content">
             
                <div class="tab-pane active" id="new">
                <div class="row row-cols-1 row-cols-md-6 g-2 mt-2 justify-content " id="card_new" >
                @foreach($packages as $package)
                        @if($package->status=='New')
                        <div class="col-md-4">
                        <div class="card ">
                            <div class="card-header bg-dark">
                                <h5>Package</h5>
                            </div>
                            <div class="card-body">
                            <h6>   <label>Date</label> ___   {{ $package -> date }} </h6>
                            <h6>  <label>Receiver_Name</label>  ___  {{ $package -> receiver_name }}</h6>
                          <h6>  <label>Receiver_Phone</label>   ___ {{ $package -> phone }}</h6>
                          <h6><label>Address </label>  ___  {{ $package -> address }}</h6>
                          <h6> <label>Township</label>  ___  {{ $package -> name }}</h6>
                          <h6> <label>Amount</label>  ___  {{ $package -> price }}</h6>
                          <h6>  <label>Delivery Fee</label>  ___  {{ $package -> delivery_fee }}</h6>
                          <h6> <label>Payment_status</label>  ___  {{ $package -> payment_status }}</h6>
                
                          <h6> <label>Delivery_Status</label>  ___ <strong class="text-primary">
                              {{ $package -> status }}</strong></h6>
                         
                       
                        
                            </div>
                            <div class="card-footer ">
                            <a href="{{url('driver_dashboard/'.$package->id.'/edit')}}">
                                <button type="button" class="btn btn-success btn-sm float-right">
                                <i class="fas fa-truck-pickup"  style="font-size: 1.5rem;" ></i> <strong>Pick Up</strong></button>
                            </a>
                            </div>
                        </div>
                        </div>
                        
                        @endif
                     @endforeach
            </div>
            
                </div>
 
                <div class="tab-pane" id="profile">
                <div class="row row-cols-1 row-cols-md-6 g-2 mt-2 justify-content " id="card_processing" >
                @foreach($packages as $package)
                        @if($package->status=='Processing')
                        <div class="col-md-4">
                        <div class="card ">
                            <div class="card-header bg-dark">
                                <h5>Package</h5>
                            </div>
                            <div class="card-body">
                            <h6>   <label>Date</label> ___   {{ $package -> date }} </h6>
                            <h6>  <label>Receiver_Name</label>  ___  {{ $package -> receiver_name }}</h6>
                          <h6>  <label>Receiver_Phone</label>   ___ {{ $package -> phone }}</h6>
                          <h6><label>Address </label>  ___  {{ $package -> address }}</h6>
                          <h6> <label>Township</label>  ___  {{ $package -> name }}</h6>
                          <h6> <label>Amount</label>  ___  {{ $package -> price }}</h6>
                          <h6>  <label>Delivery Fee</label>  ___  {{ $package -> delivery_fee }}</h6>
                          <h6> <label>Payment_status</label>  ___  {{ $package -> payment_status }}</h6>
                
                          <h6> <label>Delivery_Status</label>___  <strong class="text-warning">
                               {{ $package -> status }}</strong></h6>
                         
                       
                        
                            </div>
                            <div class="card-footer ">
                            <a href="{{url('driver_dashboard/'.$package->id.'/edit')}}">
                                <button type="button" class="btn btn-success btn-sm float-right">
                                <i class="fas fa-truck-pickup"  style="font-size: 1.5rem;" ></i> <strong>Pick Up</strong></button>
                            </a>
                            </div>
                        </div>
                        </div>
                        
                        @endif
                     @endforeach
            </div>
            
                </div>
                <div class="tab-pane" id="delivered">
                <div class="row row-cols-1 row-cols-md-6 g-2 mt-2 justify-content " id="card_deliver" >
                @foreach($packages as $package)
                        @if($package->status=='Delivered')
                        <div class="col-md-4">
                        <div class="card ">
                            <div class="card-header bg-dark">
                                <h5>Package</h5>
                            </div>
                            <div class="card-body">
                            <h6>   <label>Date</label> ___   {{ $package -> date }} </h6>
                            <h6>  <label>Receiver_Name</label>  ___  {{ $package -> receiver_name }}</h6>
                          <h6>  <label>Receiver_Phone</label>   ___ {{ $package -> phone }}</h6>
                          <h6><label>Address </label>  ___  {{ $package -> address }}</h6>
                          <h6> <label>Township</label>  ___  {{ $package -> name }}</h6>
                          <h6> <label>Amount</label>  ___  {{ $package -> price }}</h6>
                          <h6>  <label>Delivery Fee</label>  ___  {{ $package -> delivery_fee }}</h6>
                          <h6> <label>Payment_status</label>  ___  {{ $package -> payment_status }}</h6>
                
                          <h6> <label>Delivery_Status</label> ___  <strong class="text-success">
                              {{ $package -> status }}</strong></h6>
                         
                       
                        
                            </div>
                         
                        </div>
                        </div>
                        
                        @endif
                     @endforeach
            </div>
            
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
        var card_new = document.getElementById('card_new');
        var township_name = '';
         township_name = $('#township_name').val();
        var date = '';
         date = $('#date').val();
        var card_processing = document.getElementById('card_processing');
        var card_deliver = document.getElementById('card_deliver');
        card_new.innerHTML = '';
        card_deliver.innerHTML='';
        card_processing.innerHTML = '';
        var driverId = {{Auth::user()->id}}
        $.ajax({
            url:'{{route('package_list')}}',
            type:'GET',
            data:{'word':query,'township':township_name,'date':date},
            success:function(data) {
                data.forEach(item => {
                if(item.status=='New'){
                    card_new.innerHTML += 
                    '<div class="col-md-4">' +
                    '<div class="card ">'+
                    '<div class="card-header bg-dark">'+
                    '<h5>' +   'Package '+ '</h5>'+
                    '</div>'+
                    ' <div class="card-body ">'+  
                   
                    '<h6>'+   '<label> Date </label>'+ ' '+ '___ '+item.date+'</h6>'+
                    
                    '<h6>'+    '<label> Receiver_Name </label>'+ ' '+ '___' +item.receiver_name+'</h6>'+
                    '<h6>' +   '<label> Receiver_Phone </label>'+ ' '+ '___ '+item.phone+'</h6>'+
                    '<h6>' +   '<label> Address </label>'+ ' '+ '___ '+item.address+'</h6>'+
                    '<h6>' +   '<label> Township </label>'+ ' '+ '___ '+item.name+'</h6>'+
                    '<h6>' +   '<label>Price </label>'+ ' '+ '___ '+item.price+'</h6>'+
                    '<h6>' +   '<label>Delivery_fee </label>'+ ' '+ '___ '+item.delivery_fee+'</h6>'+
                    '<h6>' +   '<label>Payment_Status </label>'+ ' '+ '___ '+item.payment_status+'</h6>'+
                    '<h6>' +   '<label>Delivery_Status </label>'+ ' '+ '___ ' +'<strong class="text-primary">'+item.status+'</strong>'+'</h6>'+
                    '</div>'+
                    '<div class="card-footer">'+
                    '<button type="button" class="btn btn-success btn-sm float-right " onclick="pickUpFunc('+item.id+')">'+
                '<i class="fas fa-truck-pickup"  style="font-size: 1.5rem;" ></i> <strong>Pick Up</strong></button></td>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
                  
        
                }
                
                else if(item.status == 'Processing' && item.driver_id == driverId){
                    card_processing.innerHTML += 
                '<div class="col-md-4">' +
                    '<div class="card ">'+
                    '<div class="card-header bg-dark">'+
                    '<h5>' +   'Package '+ '</h5>'+
                    '</div>'+
                    ' <div class="card-body ">'+  
                   
                    '<h6>'+   '<label> Date </label>'+ ' '+ '___ '+item.date+'</h6>'+
                    
                    '<h6>'+    '<label> Receiver_Name </label>'+ ' '+ '___' +item.receiver_name+'</h6>'+
                    '<h6>' +   '<label> Receiver_Phone </label>'+ ' '+ '___ '+item.phone+'</h6>'+
                    '<h6>' +   '<label> Address </label>'+ ' '+ '___ '+item.address+'</h6>'+
                    '<h6>' +   '<label> Township </label>'+ ' '+ '___ '+item.name+'</h6>'+
                    '<h6>' +   '<label>Price </label>'+ ' '+ '___ '+item.price+'</h6>'+
                    '<h6>' +   '<label>Delivery_fee </label>'+ ' '+ '___ '+item.delivery_fee+'</h6>'+
                    '<h6>' +   '<label>Payment_Status </label>'+ ' '+ '___ '+item.payment_status+'</h6>'+
                    '<h6>' +   '<label>Delivery_Status </label>'+ ' '+ '___ ' +'<strong class="text-warning">'+item.status+'</strong>'+'</h6>'+
                    '</div>'+
                    '<div class="card-footer">'+
                    '<button type="button" class="btn btn-success btn-sm float-right " onclick="pickUpFunc('+item.id+')">'+
                '<i class="fas fa-truck-pickup"  style="font-size: 1.5rem;" ></i> <strong>Pick Up</strong></button></td>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
                    
                }else if(item.status == 'Delivered' && item.driver_id == driverId){
                    card_deliver.innerHTML += 
                    '<div class="col-md-4">' +
                    '<div class="card ">'+
                    '<div class="card-header bg-dark">'+
                    '<h5>' +   'Package '+ '</h5>'+
                    '</div>'+
                    ' <div class="card-body ">'+  
                   
                    '<h6>'+   '<label> Date </label>'+ ' '+ '___ '+item.date+'</h6>'+
                    
                    '<h6>'+    '<label> Receiver_Name </label>'+ ' '+ '___' +item.receiver_name+'</h6>'+
                    '<h6>' +   '<label> Receiver_Phone </label>'+ ' '+ '___ '+item.phone+'</h6>'+
                    '<h6>' +   '<label> Address </label>'+ ' '+ '___ '+item.address+'</h6>'+
                    '<h6>' +   '<label> Township </label>'+ ' '+ '___ '+item.name+'</h6>'+
                    '<h6>' +   '<label>Price </label>'+ ' '+ '___ '+item.price+'</h6>'+
                    '<h6>' +   '<label>Delivery_fee </label>'+ ' '+ '___ '+item.delivery_fee+'</h6>'+
                    '<h6>' +   '<label>Payment_Status </label>'+ ' '+ '___ '+item.payment_status+'</h6>'+
                    '<h6>' +   '<label>Delivery_Status </label>'+ ' '+ '___ ' +'<strong class="text-success">'+item.status+'</strong>'+'</h6>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
               
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
