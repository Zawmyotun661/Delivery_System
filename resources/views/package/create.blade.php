@extends('dashboardTemplate')
@section('content')

    <div class="container mt-5">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-10">
                    {{-- <form action=""> --}}
                    <div class="form-group">
                        <label for="date"> Date</label>
                        <input type="date" name="date" class="form-control"  placeholder="Enter Date" 
                        value="{{  old('date')}}" id="date">
                        <div class="errors" id="dateError"></div>
                    </div>
                <div class="form-group">
                    <label for="package_name">Package Name</label>
                    <input type="text" name="package_name" class="form-control" placeholder="Enter Package Name" 
                    value="{{ old('package_name')}}" id="package_name" required >
                </div>
                <div class="form-group">
                    <label for="package_size">Package Size</label>
                    <input type="text" name="package_size" class="form-control"  placeholder="Enter Package Size" 
                    value="{{ old('package_size')}}" id="package_size" required>
                </div>
                <div class="form-group">
                    <label for="receiver_name">Receiver Name</label>
                    <input type="text" name="receiver_name" class="form-control" placeholder="Enter Receiver Name" 
                    value="{{ old('receiver_name')}}" id="receiver_name" required >
                    <div class="errors" id="receiverError"></div>
                </div>
                <div class="form-group">
                    <label for="phone">Receiver Phone Number</label>
                    <input type="text" name="phone" class="form-control"  placeholder="Enter Number" 
                    value="{{  old('phone')}}" id="phone" required>
                    <div class="errors" id="phoneError"></div>
                </div> 
                    <div class="form-group">
                      <label for="address">Receiver Address</label>
                      <textarea name="address" rows="2" class="form-control" value="{{ old('address')}}" id="address" required></textarea>
                  </div>
                  <div class="errors" id="addressError"></div>
                  <div class="form-group mb-4">    
                    <label for="city" class="col-md-4 col-form-label ">{{ __('City') }}</label>
                    <select  class="form-select" aria-label="Default select example" name="city" id="selectBox" onchange="changeCityFunc()">
                        <option value="0">Please Select City</option>
                        @foreach($cities as $city)
                        <option value="{{ $city->id}}">{{ $city->name}}</option>
                        @endforeach
                    </select>
                    <div class="errors" id="cityError"></div>
                </div>
                <div class="form-group mb-4" id="township_div">    
                    <label for="township" class="col-md-4 col-form-label ">Township</label>
                    <select  class="form-select" aria-label="Default select example" id="township_select" name="township">
                    </select>
                    <div class="errors" id="townshipError"></div>
                </div>
                <div class="form-group">
                    <label for="price">Amount</label>
                    <input type="number" name="price" class="form-control" placeholder="Enter Price" 
                    value="{{  old('price')}}" id="amount" required>
                    <div class="errors" id="amountError"></div>
                </div>
                    <div class="form-group">
                    <label for="delivery_fee">Delivery Fee</label>
                    <input type="number" name="delivery_fee" class="form-control"  placeholder="Enter Price" 
                    value="{{  old('delivery_fee')}}" id="deli_fee" required>
                    <div class="errors" id="feeError"></div>
                    </div>
                    <div class="form-group mb-2">    
                        <label for="status" class="col-md-4 col-form-label ">{{ __('Delivery Status') }}</label>
                        <select  class="form-select" aria-label="Default select example" name="status" id="status">
                            <option value="New">New</option>
                            <option value="Paid">Paid</option>
                            <option value="Processing">Processing</option>
                            <option value="Delivered">Delivered</option>
                            <option value="Pickup">Pick Up</option>
                            <option value="Error">Error</option>
                        </select>
                        <div class="errors" id="statusError"></div>
                    </div>
                <div class="form-group">
                    <label for="remark">Remark</label>
                    <input type="text" name="remark" class="form-control"  placeholder="Enter remark" 
                    value="{{  old('remark')}}" id="remark">
                </div>
                {{-- <a href="{{url('shoppers/'.$shopperId.'/package-list')}}"> --}}
                <button class="btn btn-primary" onclick="createFunc({{$shopperId}})" type="submit">Submit</button>  
                {{-- </a> --}}
            {{-- </form> --}}
        </div>      
    </div>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">
    var township_div = document.getElementById('township_div');
    var township_select = document.getElementById('township_select');
    township_div.style.display = "none";

function changeCityFunc() {
    var selectBox = document.getElementById('selectBox');
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
     if( selectedValue != 0 )
     {
         $.ajax({
             url:'{{route('township_list')}}',
             type:'GET',
             data:{'cityId':selectedValue},
             success:function(data){
                township_select.innerHTML = '';
                data.forEach(item =>{
                    township_select.innerHTML += '<option value="'+item.id+'">'+item.name+'</option>';
                })
             }
         })
        township_div.style.display = "block";

     }else {
        township_div.style.display = "none";
     }
}

function createFunc(id) 
{
    var date = document.getElementById('date').value;
    var package_name = document.getElementById('package_name').value;
    var package_size = document.getElementById('package_size').value;
    var receiver_name = document.getElementById('receiver_name').value;
    var phone = document.getElementById('phone').value;
    var address = document.getElementById('address').value;
    var townshipId = document.getElementById('township_select').value;
    var amount = document.getElementById('amount').value;
    var deli_fee = document.getElementById('deli_fee').value;
    var status = document.getElementById('status').value;
    var remark = document.getElementById('remark').value;
    var formData = {
        'shopper_id': id,
        'date': date,
        'package_name': package_name,
        'package_size': package_size,
        'receiver_name': receiver_name,
        'phone': phone,
        'address': address,
        'townshipId': townshipId,
        'amount': amount,
        'deli_fee': deli_fee,
        'status': status,
        'remark': remark, 
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: '{{route('create_package')}}',
        type: 'POST',
        data: formData,
        success: function(response){
            console.log(response)
            window.location.assign('../../shoppers/'+id+'/package-list');
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
            if(error.responseJSON.errors.townshipId){
            $('#cityError').text('The city field is required.');
            }else {
                $('#cityError').text('');
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
            if(error.responseJSON.errors.townshipId){
                $('#selectBox').css('background-color','#FFBABA');
                $('#cityError').css('color','#D8000C');
                // $('#township_select').css('background-color','#FFBABA');
                // $('#townshipError').css('color','#D8000C');
            }else{
                $('#selectBox').css('background-color','');
                $('#cityError').css('color','');
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
</script>

@endsection