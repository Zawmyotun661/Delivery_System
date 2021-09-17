@yield('content')

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
          <a class="nav-link active" aria-current="page" href="{{url('/admin')}}">Home</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Client
          </a>
          <ul class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{url('clients')}}">Client Lists</a></li>
            
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Driver
          </a>
          <ul class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{url('drivers/create')}}">Driver Register</a></li>
            <li><a class="dropdown-item" href="{{url('drivers')}}">Driver Lists</a></li>
            
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Package
          </a>
          <ul class="dropdown-menu bg-light" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{url('packages/create')}}">Package Register</a></li>
            <li><a class="dropdown-item" href="{{url('packages')}}">Package Lists</a></li>
            
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
