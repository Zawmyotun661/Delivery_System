
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>DeliBurma</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{asset('template/img/favicon.png')}}" rel="icon">
  <link href="{{asset('template/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{asset('template/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('template/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('template/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('template/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('template/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('template/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('template/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{asset('template/css/style.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Gp - v4.6.0
  * Template URL: https://bootstrapmade.com/gp-free-multipurpose-html-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top ">
  
    <div class="container d-flex align-items-center justify-content-lg-between">

      <h1 class="logo me-auto me-lg-0"><a href="">DeliBurma<span></span></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
     
      <nav id="navbar" class="navbar order-last order-lg-0">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#features">Services</a></li>
          <!-- <li><a class="nav-link scrollto" href="#team">Team</a></li> -->
         
          <li><a class="nav-link scrollto" href="#contact">Contact</a></li>
          <li><a class="nav-link scrollto" href="{{ url('/online_shop') }}">Onlineshop</a></li>
        </ul>
        
        
      </nav>
      <!-- <div class="mx-3 mt-2">
      <ul class="order-last order-lg-0">
     
                              <li class="nav-item ">
                                  <a  class="get-started-btn scrollto" href="{{ url('/online_shop') }}">Onlineshop</a>
                              </li>
      </ul>
      </div> -->
      <div class="mx-3 mt-2">
      <ul class="order-last order-lg-0">
        @guest
                              <li class="nav-item ">
                                  <a  class="get-started-btn scrollto" href="{{ route('login') }}">LOGIN</a>
                              </li>
                             
                              @else
                              <li class="nav-item dropdown">
            <a class="nav-link  dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu  bg-white " aria-labelledby="navbarDropdown">
              <li> <a class="dropdown-item" href="{{ route('logout') }}"
                                         onclick="event.preventDefault();
                                                       document.getElementById('logout-form').submit();">
                                          {{ __('Logout') }}
                                      </a>
  
                                      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                          @csrf
                                      </form></li>
             
            </ul>
          </li>
          @if(Auth::user()->roles[0]->name == 'Admin')
          <li class="nav-item ">
            <a href="{{ url('/report_list') }}" class="get-started-btn scrollto">Logged In Dashboard</a>
        </li>
        @endif
        @if(Auth::user()->roles[0]->name == 'Client')
        <a href="{{ url('/shoppers') }}" class="get-started-btn scrollto">Logged In Dashboard</a>
        @endif
        @if(Auth::user()->roles[0]->name == 'Driver')
        <a href="{{ url('/driver_dashboard') }}" class="get-started-btn scrollto">Logged In Dashboard</a>
        @endif
      @endguest
         
        </ul>
        </div>
       <!-- .navbar -->
       
   
      
      
   
    </div>
    <i class="bi bi-list mobile-nav-toggle mx-3"></i>
  </header>
  <!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center justify-content-center">
    <div class="container" data-aos="fade-up">

      <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="150">
        <div class="col-xl-6 col-lg-8">
          <h1>Deli Burma<span></span></h1>
          <h2>Yet, Best Deli Management System in Burma!</h2>
          
        </div>
      </div>
     
      <!-- End Contact Section -->
    </div>
  </section ><!-- End Hero -->
<section id="cta" class="cta">
@yield('content')
</section>
  <main id="main">

   

    <!-- ======= Features Section ======= -->
    <section id="features" class="features">
      <div class="container" data-aos="fade-up">
        <div class="section-title">
          <h2>What's DeliBurma?</h2>
          <p>Check our Services</p>
        </div>
        <div class="row">
          <div class="image col-lg-6" style='background-image: url("{{asset('template/img/features.jpg')}}");' data-aos="fade-right"></div>
          <div class="col-lg-6" data-aos="fade-left" data-aos-delay="100">
            <div class="icon-box mt-5 mt-lg-0" data-aos="zoom-in" data-aos-delay="150">
              <i class="bx bx-receipt"></i>
              <h4>Hassel Free</h4>
              <p>Let us worry about your work. Export anywhere, anytime for your Delivery Pacakages expenses or monthly closing of accounts.</p>
            </div>
            <div class="icon-box mt-5" data-aos="zoom-in" data-aos-delay="150">
              <i class="bx bx-cube-alt"></i>
              <h4>Ease of Use</h4>
              <p>Are you still traditionally tracking your driver by multiples calls? You can track which driver pick up to send Deli in your Dashboard.</p>
            </div>
            <div class="icon-box mt-5" data-aos="zoom-in" data-aos-delay="150">
              <i class="bx bx-images"></i>
              <h4>Auto Calculation</h4>
              <p>Numbers are critical and let us help you. We will calculate every package of your delivery.</p>
            </div>
            <div class="icon-box mt-5" data-aos="zoom-in" data-aos-delay="150">
              <i class="bx bx-shield"></i>
              <h4>All in One</h4>
              <p>Track your driver, Let your customer track their package and track everything of your delivery things in one Dashboard.</p>
            </div>
          </div>
        </div>

      </div>
    </section><!-- End Features Section -->


    <!-- ======= Cta Section ======= -->
    <section id="cta" class="cta">
      <div class="container" data-aos="zoom-in">

        <div class="text-center">
          <h3>Want to Know More about Deli Burma?</h3>
          <p> Please call us now at 09 88 145 4141. </p>
		  <p>We are happy to explain you more and give you try out about our system.</p>
          <a class="cta-btn" href="tel:09881454141">Call DeliBurma Now!</a>
        </div>

      </div>
    </section><!-- End Cta Section -->

    

    <!-- ======= Contact section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contact</h2>
          <p>Contact Us</p>
        </div>

        <div>
          <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1349.749087373656!2d96.11718834488654!3d16.89236298872619!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30c194367a37b241%3A0xddcd9d8add65d3c8!2sMingalar%20St%2C%20Yangon!5e0!3m2!1sen!2smm!4v1635752517312!5m2!1sen!2smm" frameborder="0" allowfullscreen></iframe>
        </div>

        <div class="row mt-5">

          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Location:</h4>
                <p>31E Mingalar Street, Nantthar Gone, Insein, Yangon, Myanmar</p>
              </div>

              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>burmadeli@gmail.com</p>
              </div>

              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p>+95 988 145 4141</p>
              </div>

            </div>

          </div>

          <div class="col-lg-8 mt-5 mt-lg-0">

            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
                </div>
                <div class="col-md-6 form-group mt-3 mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
                </div>
              </div>
              <div class="form-group mt-3">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required>
              </div>
              <div class="form-group mt-3">
                <textarea class="form-control" name="message" rows="5" placeholder="Message" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>

          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

    </main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">
  <div class="footer-top">
    <div class="container">
      <div class="row">

        <div class="col-lg-3 col-md-6 footer-links">
    
          <div class="footer-info">
            <h3>Deli Burma</h3>
            <p>
              31E, Mingalar Street, Nantthar Gone, <br>Insein, Yangon, Myanmar<br><br>
              <strong>Phone:</strong> +95 988 145 4141<br>
              <strong>Email:</strong> burmadeli@gmail.com<br>
            </p>
           

      </div>
    </div>
  </div>

  <div class="container">
    <div class="copyright">
      &copy; Copyright <strong><span>DeliBurma</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/gp-free-multipurpose-html-bootstrap-template/ -->
      Designed by <a href="www.theburmatech.com/">The Burma Tech</a>
    </div>
  </div>
</footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('template/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('template/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('template/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('template/vendor/php-email-form/validate.js')}}"></script>
  <script src="{{asset('template/vendor/purecounter/purecounter.js')}}"></script>
  <script src="{{asset('template/vendor/swiper/swiper-bundle.min.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('template/js/main.js')}}"></script>


    </div>
</body>
</html>
