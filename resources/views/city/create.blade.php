@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{url ('city') }}" method="POST">
                    @csrf
                    <div class="form-group">
                <label for="name">City Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter City Name" 
                value="{{ old('name')}}" required >
                    </div>
                
          
                   
                   <button class="btn btn-primary">Submit</button>
                    
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
@endsection