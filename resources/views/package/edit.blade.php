@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
                <div class="col-md-6">
                    @foreach ($package as $package)
                <div class="form-group">
                    <label for="date"> Date</label>
                    <input type="date" name="date" class="form-control"  placeholder="Enter Date" 
                    value="{{ $package->date ?? old('date')}}" id="date" required>
                    <div class="errors" id="dateError"></div>
                </div>
                <div class="form-group">
                    <label for="package_name">Package Name</label>
                    <input type="text" name="package_name" class="form-control" placeholder="Enter Package Name" 
                    value="{{$package->package_name ?? old('package_name')}}" id="package_name" required >
                </div>
                <div class="form-group">
                    <label for="package_size">Package Size</label>
                    <input type="text" name="package_size" class="form-control"  placeholder="Enter Package Size" 
                    value="{{$package->package_size ?? old('package_size')}}" id="package_size" required>
                </div>
                <div class="form-group">
                    <label for="receiver_name">Receiver Name</label>
                    <input type="text" name="receiver_name" class="form-control" placeholder="Enter Receiver Name" 
                    value="{{$package->receiver_name ?? old('receiver_name')}}" id="receiver_name" required >
                    <div class="errors" id="receiverError"></div>
                </div>
                <div class="form-group">
                    <label for="phone">Receiver Phone Number</label>
                    <input type="text" name="phone" class="form-control"  placeholder="Enter Number" 
                    value="{{ $package->phone ?? old('phone')}}" id="phone" required>
                    <div class="errors" id="phoneError"></div>
                </div> 
                    <div class="form-group">
                      <label for="address">Receiver Address</label>
                      <textarea name="address" rows="2" class="form-control" id="address" required>{{$package->address ?? old('address')}}</textarea>
                      <div class="errors" id="addressError"></div>
                  </div>

                  <div class="form-group mb-4">    
                    <label for="city" class="col-md-4 col-form-label ">{{ __('City') }}</label>
                    <select  class="form-select" aria-label="Default select example" name="city" id="selectBox" onchange="changeCityFunc()">
                        @foreach($city as $city)
                        <option value="{{ $city->id}}" {{$package->city[0]->city_id == $city->id ? 'selected' : ''}}>{{ $city->name}}</option>
                        @endforeach
                    </select>
                </div>
            
                <div class="form-group mb-4">    
                    <label for="township" class="col-md-4 col-form-label ">{{ __('Township') }}</label>
                    <select  class="form-select" aria-label="Default select example" id="township_select" name="township">
                        @foreach($package->township as $township)
                        <option value="{{ $township->tId}}" {{$package->township_id==$township->tId ? 'selected' : ''}}>{{ $township->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Amount</label>
                    <input type="number" name="price" class="form-control"  placeholder="Enter Price" 
                    value="{{ $package->price ?? old('price')}}" id="amount" required>
                    <div class="errors" id="amountError"></div>
                </div>
                    
                <div class="form-group">
                    <label for="delivery_fee">Delivery Fee</label>
                    <input type="number" name="delivery_fee" class="form-control"  placeholder="Enter Price" 
                    value="{{ $package->delivery_fee ?? old('delivery_fee')}}" id="deli_fee" required>
                    <div class="errors" id="feeError"></div>
                </div>
                <div class="form-group mb-2">    
                    <label for="status" class="col-md-4 col-form-label ">{{ __('Delivery Status') }}</label>
                    <select  class="form-select" aria-label="Default select example" name="status" id="status">
                        <option value="New" {{$package->status=='New' ? 'selected' : ''}}>New</option>
                        <option value="Paid" {{$package->status=='Paid' ? 'selected' : ''}}>Paid</option>
                        <option value="Processing" {{$package->status=='Processing' ? 'selected' : ''}}>Processing</option>
                        <option value="Delivered" {{$package->status=='Delivered' ? 'selected' : ''}}>Delivered</option>
                        <option value="Pickup" {{$package->status=='Pickup' ? 'selected' : ''}}>Pick Up</option>
                        <option value="Error" {{$package->status=='Error' ? 'selected' : ''}}>Error</option>
                    </select>
                </div> 
                <div class="form-group">
                    <label for="remark">Remark</label>
                    <input type="text" name="remark" class="form-control"  placeholder="Enter remark" 
                    value="{{ $package->remark ?? old('remark')}}" id="remark" >
                    </div>
                    {{-- <a href="{{url('shoppers/'.$package->shopper_id.'/package-list')}}"> --}}
                        <button class="btn btn-primary" onclick="updateFunc({{$package->id}},{{$package->shopper_id}})">Save</button>
                    {{-- </a> --}}
                    @endforeach
                </div>
            <div class="col-md-3"></div>
        </div>
    </div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">
    function changeCityFunc() {
    var selectedValue = document.getElementById('selectBox').value;
    var township_select = document.getElementById('township_select');
    township_select.innerHTML = '';
         $.ajax({
             url:'{{route('township_list')}}',
             type:'GET',
             data:{'cityId':selectedValue},
             success:function(data){
                data.forEach(item =>{
                    township_select.innerHTML += '<option value="'+item.id+'">'+item.name+'</option>';
                })
             }
         })
}
function updateFunc(package_id, shopper_id) 
{
    var id = package_id;
    var shopper_id = shopper_id;
    var date = document.getElementById('date').value;
    var receiver_name = document.getElementById('receiver_name').value;
    var package_name = document.getElementById('package_name').value;
    var package_size = document.getElementById('package_size').value;
    var phone = document.getElementById('phone').value;
    var address = document.getElementById('address').value;
    var townshipId = document.getElementById('township_select').value;
    var amount = document.getElementById('amount').value;
    var deli_fee = document.getElementById('deli_fee').value;
    var status = document.getElementById('status').value;
    var remark = document.getElementById('remark').value;
    var formData = {
        'id': id,
        'shopper_id': shopper_id,
        'date': date,
        'receiver_name': receiver_name,
        'package_name': package_name,
        'package_size': package_size,
        'phone': phone,
        'address': address,
        'townshipId': townshipId,
        'amount': amount,
        'deli_fee': deli_fee,
        'status': status,
        'remark': remark, 
    };
    event.preventDefault();
    swal.fire({
        title: 'Are you sure?',
        text: "You want to save this changes!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, save it!',
        confirmButtonColor: '#eea025',
        cancelButtonColor: '#b1abab',
    }).then((result) => {
        if(result.isConfirmed){
            $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{route('update_package')}}',
            type: 'POST',
            data: formData,
            success: function(response){
                sessionStorage.setItem("successAlert", "You Have Successfully Updated!");
                window.location.assign('../../package-list');
            },
            error: function(error){
            if(error.responseJSON.errors.date){
                $('#dateError').text(error.responseJSON.errors.date);
            }else {
                $('#dateError').text('');
            }
            if(error.responseJSON.errors.receiver_name){
                $('#receiverError').text(error.responseJSON.errors.receiver_name);
            }else {
                $('#receiverError').text('');
            }
            if(error.responseJSON.errors.phone){
                $('#phoneError').text(error.responseJSON.errors.phone);
            }else {
                $('#phoneError').text('');
            }
            if(error.responseJSON.errors.amount){
                $('#amountError').text(error.responseJSON.errors.amount);
            }else {
                $('#amountError').text('');
            }
            if(error.responseJSON.errors.deli_fee){
                $('#feeError').text('The delivery fee field is required.');
            }else {
                $('#feeError').text('');
            }
            if(error.responseJSON.errors.date){
                $('#date').css('background-color','#FFBABA');
                $('#dateError').css('color','#D8000C');
            }else {
                $('#date').css('background-color','');
                $('#dateError').css('color','');
            }
            if(error.responseJSON.errors.receiver_name){
                $('#receiver_name').css('background-color','#FFBABA');
                $('#receiverError').css('color','#D8000C');
            }else {
                $('#receiver_name').css('background-color','');
                $('#receiverError').css('color','');
            }
            if(error.responseJSON.errors.phone){
                $('#phone').css('background-color','#FFBABA');
                $('#phoneError').css('color','#D8000C');
            }else {
                $('#phone').css('background-color','');
                $('#phoneError').css('color','');
            }
            if(error.responseJSON.errors.address){
                $('#address').css('background-color','#FFBABA');
                $('#addressError').css('color','#D8000C');
            }else {
                $('#address').css('background-color','');
                $('#addressError').css('color','');
            }
            if(error.responseJSON.errors.amount){
                $('#amount').css('background-color','#FFBABA');
                $('#amountError').css('color','#D8000C');
            }else {
                $('#amount').css('background-color','');
                $('#amountError').css('color','');
            }
            if(error.responseJSON.errors.deli_fee){
                $('#deli_fee').css('background-color','#FFBABA');
                $('#feeError').css('color','#D8000C');
            }else {
                $('#deli_fee').css('background-color','');
                $('#feeError').css('color','');
            }
        }
        })
        }
    });
    
}
</script>
@endsection