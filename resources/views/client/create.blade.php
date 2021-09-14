<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
 integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>Client Register</title>
    <style> 
    body{
        padding: 30px;
    }
</style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{url ('clients') }}" method="POST">
                    @csrf
                    <div class="form-group">
                <label for="name">Client Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter Client Name" 
                value="{{ old('name')}}" required >
                    </div>
                    <div class="form-group">
                <label for="country">Country</label>
                <input type="text" name="country" class="form-control" placeholder="Enter Country Name" 
                value="{{ old('country')}}" required >
                    </div>
                    <div class="form-group">
                <label for="city">City</label>
                <input type="text" name="city" class="form-control" placeholder="Enter City Name" 
                value="{{ old('city')}}" required >
                    </div>
                    <div class="form-group">
                <label for="township">Township</label>
                <input type="text" name="township" class="form-control" placeholder="Enter Township Name" 
                value="{{ old('township')}}" required >
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
                  value="{{ old('address')}}" required>

                  </textarea>
              </div>

                   <div class="form-group">
                       <label for="phone">Contact Number</label>
                       <input type="number" name="phone" class="form-control" placeholder="Enter Contact Number"
                       value="{{ old('phone')}}"  required> 
                   </div>
                   
                   <button class="btn btn-primary">Submit</button>
                    
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