<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
 integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

    <title>Customer Dashboard</title>
    <style> 
    body{
        padding: 30px;
    }
</style>
</head>
<body>
    <div class="container-fluid">
        <div class="col-md-12">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Delivery_System</a>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="{{url('/customer')}}">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Package
          </a>
          <ul class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{url('packages/create')}}">Packages Register</a></li>
            <li><a class="dropdown-item" href="{{url('packages')}}">Packages Lists</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Location 
          </a>
          <ul class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{url('country')}}">Country</a></li>
            <li><a class="dropdown-item" href="{{url('city')}}">City</a></li>
            <li><a class="dropdown-item" href="{{url('township')}}">Township</a></li>
          </ul>
        </li>
       


        
        <li class="nav-item">
          <a class="nav-link text-white" href="{{url('clients')}}">Client</a>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto me-4 mb-lg-0">
    
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           {{Auth::user()->name}}
          </a>
          <ul class="dropdown-menu " aria-labelledby="navbarDropdown">
            <form action="{{url('/logout')}}" method="POST">
              @csrf
              <button type="submit" class="dropdown-item"> Logout </button>
            </form>
            
          </ul>
        </li>
        
      </ul>
    
    </div>
  </div>

</nav>

        </div>
    </div>  


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>