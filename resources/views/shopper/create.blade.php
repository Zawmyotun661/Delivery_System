@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{url ('shoppers') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Customer Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Customer Name" 
                        value="{{ old('name')}}" required >
                    </div>
                    <div class="form-group">
                        <label for="name">Phone Number</label>
                        <input type="number" name="phone" class="form-control" placeholder="Enter Phone Number" 
                        value="{{ old('phone')}}" required >
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" rows="2" class="form-control" required></textarea>
                    </div>
                   
                   <button class="btn btn-primary">Create</button>
                    
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
@endsection