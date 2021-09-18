<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
 integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>Package Update</title>
    <style> 
    body{
        padding: 50px;
    }
</style>
</head>
<body>

    <div class="container">
    
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
             
                <form action="{{url ('packages/'.$package->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                <label for="package_name">Package Name</label>
                <input type="text" name="package_name" class="form-control" placeholder="Enter Package Name" 
                value="{{ $package->title ?? old('package_name')}}" required >
                    </div>

                    <div class="form-group">
                <label for="package_size">Package Size</label>
                <input type="text" name="package_size" class="form-control"  placeholder="Enter Package Size" 
                value="{{$package->size ?? old('package_size')}}" required>
                </div>


                <div class="form-group">
                <label for="package_type">Package Type</label>
                <input type="text" name="package_type" class="form-control"  placeholder="Enter Package Type" 
                value="{{ $package->type ?? old('package_type')}}" required>
                </div>

            
              <div class="form-group mb-2">    
     <label for="country" class="col-md-4 col-form-label text-md-right">{{ __('Country') }}</label>
        
     <select  class="form-select" aria-label="Default select example" name="country">
        @foreach($country as $country)
         <option value="{{$country->name}}">{{ $country->name}}</option>
        @endforeach
    </select>
         
        </div>
            
        <div class="form-group mb2">    
     <label for="city" class="col-md-4 col-form-label text-md-right">{{ __('City') }}</label>
        
     <select  class="form-select" aria-label="Default select example" name="city">
        @foreach($city as $city)
         <option value="{{ $city->name}}">{{ $city->name}}</option>
        @endforeach
    </select>
         
        </div>
            
        <div class="form-group mb-4">    
     <label for="township" class="col-md-4 col-form-label text-md-right">{{ __('Township') }}</label>
        
     <select  class="form-select" aria-label="Default select example" name="township">
        @foreach($township as $township)
         <option value="{{ $township->name}}">{{ $township->name}}</option>
        @endforeach
    </select>
         
        </div>

            
             
                   
                   <button class="btn btn-primary">Update</button>
                    
                </form>
              
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>