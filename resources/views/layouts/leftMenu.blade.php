 <!-- Main Sidebar Container -->
 <aside class="main-sidebar sidebar-dark-primary elevation-4" 
 style="background: linear-gradient(to right, rgb(31, 28, 44), rgb(146, 141, 171))" >

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-2 pb-1 mb-3 d-flex">
        <div class="image">
        <i class="far fa-user text-white" style="font-size: 30px;"></i>
        </div>
        <div class="info">
          <h5 class="text-white">{{ Auth::user()->name }}</h5>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @if(Auth::user()->roles[0]->name == 'Admin')
          <li class="nav-item">
            <a href="{{ url('/report_list') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Report List
              </p>
            </a>
          </li>
          @endif
          @if(Auth::user()->roles[0]->name == 'Admin')
          <li class="nav-item">
            <a href="{{ url('/clients') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Client List
              </p>
            </a>
          </li>
          @endif
          @if(Auth::user()->roles[0]->name == 'Admin')
          <li class="nav-item ">
            <a href="{{ url('/admin/user_list') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                User List
              </p>
            </a>
          </li>
          @endif
          
          @if(Auth::user()->roles[0]->name == 'Driver')
          <li class="nav-item">
            <a href="{{ url('/driver_dashboard') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Report List 
              </p>
            </a>
          </li>
          @endif
          
          @if(Auth::user()->roles[0]->name == 'Client')
          <li class="nav-item">
            <a href="{{ url('/shoppers') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                 Customer List
              </p>
            </a>
          </li>
          @endif
          @if(Auth::user()->roles[0]->name == 'Client')
          <li class="nav-item">
            <a href="{{ url('/drivers') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Driver List
              </p>
            </a>
          </li>
          @endif
          @if(Auth::user()->roles[0]->name == 'Client')
          <li class="nav-item">
            <a href="{{ url('/packages') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Package List
              </p>
            </a>
          </li>
          @endif
          @if(Auth::user()->roles[0]->name == 'Admin')
          <li class="nav-item">
            <a href="{{ url('/township') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Township List
              </p>
            </a>
          </li>
          @endif
          @if(Auth::user()->roles[0]->name == 'Admin')
          <li class="nav-item">
            <a href="{{ url('/city') }}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                City List
              </p>
            </a>
          </li>
          @endif
         
       
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item has-treeview menu-open">
          <a href="{{ route('logout') }}" class="nav-link active bg-dark" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt nav-icon"></i>
            <p>Logout</p>
          </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                  @csrf
            </form>
         
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    
    <!-- /.sidebar -->
  </aside>
  <!-- <script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.nav-link').forEach(link => {
        if (link.getAttribute('href').toLowerCase() === location.pathname.toLowerCase()) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
})
</script> -->