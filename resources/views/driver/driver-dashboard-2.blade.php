@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
                <div class="col-md-6">
                    @foreach ($package as $package)
                    <form action="{{url ('driver_dashboard/'.$package->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                    <label for="date"> Date</label>
                    <input type="date" name="date" class="form-control"  placeholder="Enter Date" 
                    value="{{ $package->date ?? old('date')}}" disabled>
                </div>
                <div class="form-group">
                    <label for="package_name">Package Name</label>
                    <input type="text" name="package_name" class="form-control" placeholder="Enter Package Name" 
                    value="{{$package->package_name ?? old('package_name')}}" disabled >
                </div>
                <div class="form-group">
                    <label for="package_size">Package Size</label>
                    <input type="text" name="package_size" class="form-control"  placeholder="Enter Package Size" 
                    value="{{$package->package_size ?? old('package_size')}}" disabled>
                </div>
                <div class="form-group">
                    <label for="receiver_name">Receiver Name</label>
                    <input type="text" name="receiver_name" class="form-control" placeholder="Enter Customer Name" 
                    value="{{$package->receiver_name ?? old('receiver_name')}}" disabled >
                </div>
                <div class="form-group">
                    <label for="phone">Receiver Phone Number</label>
                    <input type="text" name="phone" class="form-control"  placeholder="Enter Number" 
                    value="{{ $package->phone ?? old('phone')}}" disabled>
                </div> 
                    <div class="form-group">
                      <label for="address">Receiver Address</label>
                      <textarea name="address" rows="2" class="form-control"  disabled>
                      {{$package->address ?? old('address')}}
                      </textarea>
                  </div>
                <div class="form-group">
                    <label for="township">Township</label>
                    <input type="text" name="name" class="form-control"
                    value="{{ $package->name ?? old('name')}}" disabled>
                </div>
                <div class="form-group">
                    <label for="price">Amount</label>
                    <input type="number" name="price" class="form-control"  placeholder="Enter Price" 
                    value="{{ $package->price ?? old('price')}}" disabled>
                    </div>
                    <div class="form-group" id="depositDiv" style="display: none;">
                        <label for="deposit">Deposit</label>
                        <input type="number" name="deposit" class="form-control" placeholder="Enter Price" 
                        value="{{ $package->deposit ?? old('price')}}" id="deposit" disabled>
                    </div>
                    
                    <div class="form-group">
                    <label for="delivery_fee">Delivery Fee</label>
                    <input type="number" name="delivery_fee" class="form-control"  placeholder="Enter Price" 
                    value="{{ $package->delivery_fee ?? old('delivery_fee')}}" disabled>
                    </div>
                <div class="form-group mb-2">    
                    <label for="status" class="col-md-4 col-form-label ">{{ __('Delivery Status') }}</label>
                    <select  class="form-select" aria-label="Default select example" name="status">
                        <option value="New" {{$package->status == 'New' ? 'selected' : ''}}>New</option>
                        <option value="Paid" {{$package->status=='Paid' ? 'selected' : ''}}>Paid</option>
                        <option value="Processing" {{$package->status=='Processing' ? 'selected' : ''}}>Processing</option>
                        <option value="Delivered" {{$package->status=='Delivered' ? 'selected' : ''}}>Delivered</option>
                        <option value="Pickup" {{$package->status=='Pickup' ? 'selected' : ''}}>Pick Up</option>
                        <option value="Error" {{$package->status=='Error' ? 'selected' : ''}}>Error</option>
                    </select>
                </div>  
                <div class="form-group mb-2">    
                    <label for="payment_status" class="col-md-4 col-form-label ">{{ __('Payment Status') }}</label>
                    <select  class="form-select" aria-label="Default select example" name="payment_status">
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Cash">Cash</option>
                        
                    </select>
                </div>  
                <div class="form-group">
                    <label for="remark">Remark</label>
                    <input type="text" name="remark" class="form-control"  placeholder="Enter remark" 
                    value="{{ $package->remark ?? old('remark')}}" >
                </div>
                <div class="form-group">
                    <label for="image">Receipt</label>
                    <input type="file" name="file" class="form-control">
                    </div>
                        <button class="btn btn-primary" id="update">Save</button>
                    </form>
                    @endforeach
                </div>
            <div class="col-md-3"></div>
        </div>
    </div>
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    document.getElementById("update").addEventListener('click', function(e){
        e.preventDefault();
        var form = $(this).parents('form');
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
                form.submit();
            }
        });
    });
});
</script>