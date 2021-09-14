<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
 integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>Company Register</title>
    <style> 
    body{
        padding: 100px;
    }
</style>
</head>
<body>
    <div class="container">
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
                  value="{{ old('address')}}" required>

                  </textarea>
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


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>