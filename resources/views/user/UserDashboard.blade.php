@extends('layouts.app2')

@section('content')
<style> 
.card h5 {
    line-height: 2;
    text-align: center;
}
.card .ss {
    text-align: left;
}
.card {
    font-family: sans-serif;
    background-color: #fff;
    border-radius: 20px;
    border: none;
    position: relative;
    margin-bottom: 30px;
}
.l-bg-blue-dark {
    /* background:linear-gradient(to right, rgb(70 95 112), rgb(44, 62, 80)); */
    background: linear-gradient(to right, rgb(15, 32, 39), rgb(32, 58, 67), rgb(44, 83, 100)) !important;
    color: white;
}
.l-bg-green-dark {
    background: linear-gradient(to right, #0a504a, #38ef7d) !important;
    color: #fff;
}
.l-bg-orange-dark {
    background: linear-gradient(to right, #a86008, #ffba56) !important;
    color: #fff;
}
</style>
<section>
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
                            style="width: 130px; padding:10px; border-radius:20px ;  background: linear-gradient(to right, rgb(15, 32, 39), rgb(32, 58, 67), rgb(44, 83, 100))">
                                <i class="fa fa-search">  Track Your Deli </i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <div class="row row-cols-1 row-cols-md-3 g-4 justify-content-center " id="card" >
</div>
</div>
</section>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('#search').on('click', function(){
            var query = $('#name').val();
            var card = document.getElementById('card');
            card.innerHTML = '';
            $.ajax({
                url:'{{route('search_user')}}',
                type:'GET',
                data:{'name':query},
                success:function(data) {
                    console.log(data)
                   
                    if( data===query){
                        console.log("if work")
                    data.forEach(item => {
                    card.innerHTML += 
                    '<div class="col">' +
                    '<div class="card l-bg-blue-dark">'+
                    ' <div class="card-body ">'+  
                   '<div class="mb-4">'+
                    '<h5>'+   '<label> Package Name </label>'+ ' '+ ':: '+item.package_name+'</h5>'+
                    
                    '<h5>'+    '<label> Receiver Name </label>'+ ' '+ ':: ' +item.receiver_name+'</h5>'+
                 
                    '<h5>' +   '<label> Delivery Status </label>'+ ' '+ ':: '+item.status+'</h5>'+
                    '<h5>' +   '<label> Driver Name </label>'+ ' '+ ':: '+item.driver_name+'</h5>'+
                   
                  '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
                    })
                } 
                 else if(!query==data) { 
                     console.log("else if")
                    card.innerHTML += 
                    '<div class="col">' +
                    '<div class="card l-bg-blue-dark">'+
                    ' <div class="card-body ">'+  
                   '<div class="mb-4">'+
                    '<h5>'+   'Please Type Your Phone Number Correctly!!' +'</h5>'+
                    
                   
                  '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
                 
                }
                else  { 
                    data.forEach(item => {
                    card.innerHTML += 
                    '<div class="col">' +
                    '<div class="card l-bg-blue-dark">'+
                    ' <div class="card-body ">'+  
                   '<div class="mb-4">'+
                    '<h5>'+   '<label> Package Name </label>'+ ' '+ ':: '+item.package_name+'</h5>'+
                    
                    '<h5>'+    '<label> Receiver Name </label>'+ ' '+ ':: ' +item.receiver_name+'</h5>'+
                 
                    '<h5>' +   '<label> Delivery Status </label>'+ ' '+ ':: '+item.status+'</h5>'+
                    '<h5>' +   '<label> Driver Name </label>'+ ' '+ ':: '+item.driver_name+'</h5>'+
                   
                  '</div>'+
                    '</div>'+
                    '</div>'+
                    '</div>';
                    })
                 
                }
            }
        })
    }); 
});
</script>
@endsection
