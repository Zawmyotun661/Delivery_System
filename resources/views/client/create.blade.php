@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                @if (isset($client))
                @foreach ($client as $client)
                    <form action="{{url ('clients/'.$client->id) }}" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Client Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Client Name" 
                            value="{{ $client->name }}" required >
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control"  placeholder="Enter Email" 
                            value="{{ $client->email }}" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" rows="2" class="form-control"
                            value="{{ $client->address }}" required>{{ $client->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone">Contact Number</label>
                            <input type="number" name="phone" class="form-control" placeholder="Enter Contact Number"
                                value="{{ $client->phone }}"  required> 
                        </div>
                        <div class="form-group">
                            <label for="package">Total Package</label>
                            <input type="number" name="package" class="form-control" placeholder="Enter Total Package"
                            value="{{ $client->total_package }}"  required> 
                        </div>
                        <button class="btn btn-primary" id="update">Save</button>
                    </form>
                @endforeach
                @else
                    <form action="{{url ('clients/') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Client Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Client Name" 
                            value="{{ old('name')}}" required >
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control"  placeholder="Enter Email" 
                            value="{{ old('email')}}" required>
                        </div>
                    
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control"  placeholder="Enter Password" 
                        value="{{ old('password')}}" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea name="address" rows="2" class="form-control"
                            value="{{ old('address')}}" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="phone">Contact Number</label>
                            <input type="number" name="phone" class="form-control" placeholder="Enter Contact Number"
                            value="{{ old('phone')}}"  required> 
                        </div>
                        <div class="form-group">
                            <label for="package">Total Package</label>
                            <input type="number" name="package" class="form-control" placeholder="Enter Total Package"
                            value="{{ old('package')}}"  required> 
                        </div>
                    <button class="btn btn-primary">Create</button>
                    </form>
                @endif
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
@endsection
<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
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
</script> -->