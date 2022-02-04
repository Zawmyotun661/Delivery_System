<style>
  @import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");

:root {
    --header-height: 3rem;
    --nav-width: 180px;
    --black-color: black;
    --first-color: #4723D9;
    --first-color-light: #AFA5D9;
    --white-color: #F7F6FB;
    --body-font: 'Nunito', sans-serif;
    --normal-font-size: 1rem;
    --z-fixed: 100
}

*,
::before,
::after {
    box-sizing: border-box
}

body {
    position: relative;
    margin: calc(var(--header-height) + 3rem) 0 0 0;
    padding: 0 1rem;
    font-family: var(--body-font);
    font-size: var(--normal-font-size);
    transition: .5s
}

a {
    text-decoration: none
}

.header {
    width: 100%;
    height: var(--header-height);
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 1rem;
    background-color: var(--white-color);
    z-index: var(--z-fixed);
    transition: .5s;
  
    
}

.header_toggle {
    color: black;
    font-size: 1.5rem;
    cursor: pointer
}



.l-navbar {
    position: fixed;
    top: 0;
    left: -50%;
    width: var(--nav-width);
    height: 100vh;
    background-color: var(--first-color);
    padding-top: 10px;
    padding-left: 10px;
    padding-right: 10px; 
    transition: .5s;
    z-index: var(--z-fixed)
}

.nav {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    overflow: hidden
}

.nav_logo,
.nav_link {
    display: grid;
    grid-template-columns: max-content max-content;
    align-items: center;
    column-gap: 1rem;
    padding: .5rem 0 .5rem 1.5rem
}

.nav_logo {
    margin-bottom: 2rem
}

.nav_logo-icon {
    font-size: 1.25rem;
    color: var(--white-color)
}

.nav_logo-name {
    color: var(--white-color);
    font-weight: 700
}

.nav_link {
    position: relative;
    color: var(--first-color-light);
    margin-bottom: 1.5rem;
    transition: .3s
}

.nav_link:hover {
    color: var(--white-color)
}

.nav_icon {
    font-size: 1.25rem
}

.show {
    left: 0
}

.body-pd {
    padding-left: calc(var(--nav-width) + 1rem)
}

.active {
    color: var(--white-color)
}

.active::before {
    content: '';
    position: absolute;
    left: 0;
  
    background-color: var(--white-color)
}

.height-100 {
    height: 100vh
}

@media screen and (min-width: 768px) {
    body {
        margin: calc(var(--header-height) + 3rem) 0 0 0;

    }
    .l-navbar {
        left: 0;
        padding: 1rem 0 0 0;
        padding-left: 10px;
        padding-right: 10px;
    }

   

    .body-pd {
        padding-left: calc(var(--nav-width) + 100px)
    }
}
</style>

<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='fas fa-bars' id="header-toggle"></i> </div>
        
    </header>
    <div class="l-navbar" id="nav-bar" style="background: linear-gradient(to right, rgb(31, 28, 44), rgb(146, 141, 171))">
        <nav class="nav">
            <div> <a href="#" class="nav_logo">  <i class="far fa-user text-white" style="font-size: 25px;"></i>
            <h5 class="text-white">{{ Auth::user()->name }}</h5> </a>
                <div class="nav_list"> 
                @if(Auth::user()->roles[0]->name == 'Admin')
                  <a href="{{ url('/report_list') }}" class="nav_link active">
                  <i class="nav-icon fas fa-th"></i>
                     <span class="nav_name"> Report List</span> 
                    </a>
                      <a href="{{ url('/clients') }}" class="nav_link active"> 
                      <i class="nav-icon fas fa-th"></i>
                        <span class="nav_name">  Client List</span> 
                      </a> 
                        <a href="{{ url('/admin/user_list') }}" class="nav_link active"> 
                        <i class="nav-icon fas fa-th"></i>
                        <span class="nav_name"> User List</span>
                       </a>  
                        <a href="{{ url('/township') }}" class="nav_link active">
                        <i class="nav-icon fas fa-th"></i>
                         <span class="nav_name">  Township List</span> 
                          </a> 
                           <a href="{{ url('/city') }}" class="nav_link active">  
                            <i class="nav-icon fas fa-th"></i>
                            <span class="nav_name">  City List</span> 
                          </a> 
                            
                             @endif
                             @if(Auth::user()->roles[0]->name == 'Client')
                             <a href="{{ url('/shoppers') }}" class="nav_link active ">
                  <i class="nav-icon fas fa-th"></i>
                     <span class="nav_name">Customer List </span> 
                    </a>
                      <a href="{{ url('/drivers') }}" class="nav_link active"> 
                      <i class="nav-icon fas fa-th"></i>
                        <span class="nav_name">Driver List </span> 
                      </a> 
                        <a href="{{ url('/packages') }}" class="nav_link active"> 
                        <i class="nav-icon fas fa-th"></i>
                        <span class="nav_name">Package List </span>
                       </a> 
                        
                             @endif
                             @if(Auth::user()->roles[0]->name == 'Driver')
                             <a href="{{ url('/driver_dashboard') }}" class="nav_link " style="color: white;"> 
                      <i class="nav-icon fas fa-th"></i>
                        <span class="nav_name"> Report List  </span> 
                      </a> 
                      
                             @endif
                            </div>
                            <a href="{{ route('logout') }}" class="nav-link bg-dark" onclick="event.preventDefault();document.getElementById('logout-form').submit();" style="border-radius: 10px;">
            <i class="fas fa-sign-out-alt nav-icon"></i>
            <span class="nav_name">SignOut</span> </a>
          </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                  @csrf
            </form>
        </nav>
            </div> 
            
    </div>
  
  
    <script> 
    document.addEventListener("DOMContentLoaded", function(event) {

const showNavbar = (toggleId, navId, bodyId, headerId) =>{
const toggle = document.getElementById(toggleId),
nav = document.getElementById(navId),
bodypd = document.getElementById(bodyId),
headerpd = document.getElementById(headerId)

// Validate that all variables exist
if(toggle && nav && bodypd && headerpd){
toggle.addEventListener('click', ()=>{
// show navbar
nav.classList.toggle('show')
// change icon
toggle.classList.toggle('bx-x')
// add padding to body
bodypd.classList.toggle('body-pd')
// add padding to header
headerpd.classList.toggle('body-pd')
})
}
}

showNavbar('header-toggle','nav-bar','body-pd','header')

/*===== LINK ACTIVE =====*/
const linkColor = document.querySelectorAll('.nav_link')

function colorLink(){
if(linkColor){
linkColor.forEach(l=> l.classList.remove('active'))
this.classList.add('active')
}
}
linkColor.forEach(l=> l.addEventListener('click', colorLink))

// Your code to run since DOM is loaded and ready
});
    </script>

    <!--Container Main end-->