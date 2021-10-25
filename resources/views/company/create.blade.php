<!DOCTYPE html>
@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{url ('companies') }}" method="POST">
                    @csrf
                    <div class="form-group">
                <label for="name">Company Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Company Name" 
                value="{{ old('name')}}" required >
                    </div>

                    <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" class="form-control"  placeholder="Enter Email" 
                value="{{ old('email')}}" required>
                </div>

            
            
              <div class="form-group">
                  <label for="address">Address</label>
                  <textarea name="address" rows="3" class="form-control" placeholder="Enter Address..." 
                  value="{{ old('address')}}" required></textarea>
              </div>

                   <div class="form-group">
                       <label for="ph">Phone Number</label>
                       <input type="number" name="ph" class="form-control" placeholder="Enter Phone number"
                       value="{{ old('ph')}}"  required> 
                   </div>
                   
                   <button class="btn btn-primary">Submit</button>
                    
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>


@endsection