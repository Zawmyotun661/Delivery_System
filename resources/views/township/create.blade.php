@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{url ('township') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="city">City</label>  
                    <select  class="form-select" aria-label="Default select example" name="cityId">
                        <option value="">Please Select City</option>
                        @foreach($cities as $city)
                        <option value="{{$city->id}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                    <br>
                        <label for="name">Township Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Township Name" 
                        value="{{ old('name')}}" required >
                    </div>
                   <button class="btn btn-primary">Submit</button>
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>


@endsection