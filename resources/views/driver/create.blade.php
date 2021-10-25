@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                @if (isset($driver))
                <form action="{{url('drivers/'.$driver->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">Driver Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Driver Name" 
                        value="{{ $driver->name }}" required >
                    </div>
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $driver->email }}" required placeholder="Enter Driver Email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Enter Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" rows="2" class="form-control"
                        value="{{ $driver->address }}" required>{{ $driver->address }}</textarea>
                    </div>

                   <div class="form-group">
                       <label for="phone">Contact Number</label>
                       <input type="number" name="phone" class="form-control" placeholder="Enter Contact Number"
                       value="{{ $driver->phone }}"  required> 
                   </div>
                   
                   <button class="btn btn-primary" id="update">Save</button>
                    
                </form>
                @else
                <form action="{{url ('drivers') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Driver Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Driver Name" 
                        value="{{ old('name')}}" required >
                    </div>
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Enter Driver Email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required placeholder="Enter Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
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
                   <button class="btn btn-primary">Create</button>
                </form>
                @endif
                
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