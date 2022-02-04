<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>DeliBurma</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->

<!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="{{asset('template/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('template/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('template/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('template/vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('template/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
  <!-- Google 

  <!-- =======================================================
  * Template Name: Gp - v4.6.0
  * Template URL: https://bootstrapmade.com/gp-free-multipurpose-html-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<style>
    body {
  font-family: "Open Sans", sans-serif;
  color: #444444;
}

#header {
  transition: all 0.5s;
  z-index: 997;
  padding: 15px 0;
  
}
#header.header-scrolled, #header.header-inner-pages {
  background: rgba(0, 0, 0, 0.8);
}
#header .logo {
  font-size: 32px;
  margin: 0;
  padding: 0;
  line-height: 1;
  font-weight: 700;
  letter-spacing: 2px;
  text-transform: uppercase;
}
#header .logo a {
  color: #fff;
}
#header .logo a span {
  color: #ffc451;
}
#header .logo img {
  max-height: 40px;
}
#header button a {
    text-decoration: none;
    color: yellow;

}
#header button {
    border: 1px solid #ffc451;
    border-radius: 5px;
    padding-top: 6px;
    padding-bottom: 6px;
    padding-left: 15px;
    padding-right: 15px;
    background: black;
    
}


    </style>
<body>

  <!-- ======= Header ======= -->
  <header id="header" style="background: black; padding: 20px;" >
    <div class="container d-flex align-items-center justify-content-lg-between">

      <h1 class="logo me-auto me-lg-0"><a href="/" style="text-decoration: none;">DeliBurma<span></span></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

 
      <div class="mx-3 mt-2">
      <button class="btn btn-sm" >
                                <a  class="get-started-btn scrollto" href="{{ url('/') }}">Home</a>
                              </li>
      </button>
      </div>
     
       <!-- .navbar -->
       <!-- <i class="bi bi-list mobile-nav-toggle"></i> -->
   
    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <body>
        
<section id="cta" class="cta">

</section>
<section >
<div class="container">
    <div class="row justify-content-center" style="padding-top: 10px; padding-bottom:60px">
        <div class="col-md-8">
            <div class="card" >
                <div class="card-header">
                    <div class="input-group" id="myDiv">
                        <input class="form-control border" type="search" id="name"
                            placeholder="Track Your Phone Number" value="" style="border-radius: 3px;">
                        <div style="padding-left: 10px;">
                            <button class="btn btn-primary border px-2" id="search" 
                            style="width: 180px; padding:10px; border-radius:20px ;  background: linear-gradient(to right, rgb(15, 32, 39), rgb(32, 58, 67), rgb(44, 83, 100))">
                                <i class="fa fa-search">  Track Your Package </i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="show" style="display: none;">
    <div class="row mb-3 mt-5">
                
                    <label for="date"> Filter by Date</label>
                    <div class="form-group col-md-3">
                        <input type="date" name="date" class="form-control"  placeholder="Enter Date" id="date">
                    </div>
                    <div class="form-group col-md-3">
                        <select  class="form-select" aria-label="Default select example"  id="township_name">
                            <option value="">Filter by Township </option>
                            @foreach($township as $town)
                            <option value="{{$town->name}}">{{$town->name}}</option>
                          @endforeach
                        </select>
                    </div>
                    <br>
                    <div class="col-md-6 mx-auto">
                    <div class="input-group" id="myDiv">
                        <input class="form-control border" type="search" id="s_name"
                            placeholder="Filter by Client Name" value="" style="border-radius: 3px;">
                        
                    </div>
                    </div>
                </div>
    
    
    </div>
    <div class="col-md-12">
    <table class="table table-bordered table-hover" data-show-footer="true">
                    <thead>
                        <tr>
                            <th class="px-5"> Date </th>
                            <th class="px-5"> Client Name </th>
                            <th class="px-3">Customer Name/Online Shop Name</th>
                            <th class="px-3">Receiver Name</th>
                            <th class="px-5">Receiver Phone Number </th>
                            <th class="px-5">Receiver Address</th>
                            <th class="px-3">Township </th>
                            <th class="px-3">Amount </th>
                            <th class="px-3">Delivery Fee </th>
                    
                            <th class="px-3">Delivery Status </th>
                            <th class="px-3"> Package Name </th>
                            <th> Package Size </th>
                            <th class="px-3">Remark</th>
                           
                        </tr>
                    </thead>
                    <tbody id="table_body">
                    </tbody>
                    <tfoot id="table_footer">
                  
                       
                    </tfoot>
                    
    </table>
    </div>  
    <!-- <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center " id="card" >
</div> -->
</div>
</section>
  </body>
  </html>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#search',).on('click', function(){
            var query = $('#name').val();
            var tbody = document.getElementById('table_body');
            var tfoot = document.getElementById('table_footer');
            var show = document.getElementById('show');
            var name = $('#s_name').val();
            var date = '';
         date = $('#date').val();
         var township = '';
         township = $('#township_name').val();
            tbody.innerHTML = '';
            tfoot.innerHTML='';
            $.ajax({
                url:'{{route('online_shop_search')}}',
                type:'GET',
                data:{'name':query,'searchDate':date,'word':name,'township':township},
                success:function(data) {
                
                 var package = data.data;
               if(!data==query || !query || !data )  { 
                console.log("error")
                show.style.display = "none";
                
                
               } else {
                  
                  
                    package.forEach(item => {
                        show.style.display = "block";
                                    if(item.remark==null){
                        item.remark= ""; 
                    }else{
                        item.remark=item.remark;
                    }
                 
                    tbody.innerHTML +=
                    '<tr>'+
                    '<td>'+item.date+'</td>'+
                    '<td>'+item.client_name+'</td>'+
                    '<td>'+item.shopper_name+'</td>'+
                    '<td>'+item.receiver_name+'</td>'+
                    '<td>'+item.phone+'</td>'+
                    '<td>'+item.address+'</td>'+
                    '<td>'+item.name+'</td>'+
                    '<td>'+item.price+'</td>'+
                    '<td>'+item.delivery_fee+'</td>'+
          
                    '<td>'+item.status+'</td>'+
                    '<td>'+item.package_name+'</td>'+
                    '<td>'+item.package_size+'</td>'+
                    '<td>'+item.remark+'</td>'+
                    '<tr>';
               
                    }   )
                     
                    tfoot.innerHTML += 
                   
                 '<tr><th>Total_amount</th><th colspan="12">'+data.total_price+
                 '</th></tr>'+'<tr><th>Total Delivery</th><th colspan="12">'+data.total_delivery+'</th></tr>'+
                 '<tr><th>Final Amount</th><th colspan="12">'+data.final_amount+'</th></tr>';
                }
            }
        })
    }); 
});
</script>

