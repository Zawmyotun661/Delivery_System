@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{url ('shoppers/'.$shopper->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Customer Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Customer Name" 
                        value="{{$shopper->name ?? ('name')}}" required >
                    </div>
                    <div class="form-group">
                        <label for="name">Phone Number</label>
                        <input type="number" name="phone" class="form-control" placeholder="Enter Phone Number" 
                        value="{{$shopper->phone ??  old('phone')}}" required >
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" rows="2" class="form-control" required>{{$shopper->address }}</textarea>
                    </div>
                   <button class="btn btn-primary" id="update">Save</button>
                </form>
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
                // window.location.href = 'shoppers/'+id+'/destroy';
            }
        });
    });
});
</script>