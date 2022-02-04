
@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
            <h5 class="mb-5">Customer Lists</h5>
            
            <div class="col-md-6 mx-auto">
                <div class="input-group" id="myDiv">
                    <input class="form-control border" type="search" id="searchWord" placeholder="Filter by Name or Phone Number" value="" style="border-radius: 3px;">
                    <div class="pl-4">
                        <button class="btn btn-primary border px-2" id="search" onclick="search()" style="width: 130px; padding:10px;border-radius:20px ;">
                            <i class="fa fa-search">Search</i>
                        </button>
                    </div>
                </div>
            </div>
                <a href="{{url('shoppers/create')}}">
                    <button class="btn btn-primary btn-sm mb-2">
                        <i class="fa fa-plus-circle"></i> Add New
                    </button>
                </a>
                @if(Session('successAlert'))
                <div class="alert alert-success alert-dismissible show fade">
                    <strong>{{Session('successAlert')}}</strong>
                    <button class="close" data-dismiss="alert">&times;</button>
                </div>
                @endif
                <table class="table table-bordered table-hover ">
                    <thead  class="thead-dark">
                        <tr>
                            <th>Customer Name/Online shop Name</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Total Amount</th>
                            <th class="col-5">Action</th>
                            
                        </tr>
                    </thead>
                    <tbody id="tableBody">
                       @foreach($shopper as $shopper)
                       <tr>
                           <td >{{ $shopper -> name }}</td>
                           <td >{{ $shopper -> phone }}</td>
                           <td >{{ $shopper -> address }}</td>
                           <td>{{ $shopper->amount }}</td>
                           <td>
                               
                               <a href="{{url('shoppers/'.$shopper->id.'/package-list')}}" style="text-decoration: none;"> 
                                    <button type="button" class="btn btn-dark btn-sm">
                                    <i class="fas fa-list-alt"></i> Package List</button>
                               </a>
                               <a href="{{url('shoppers/'.$shopper->id.'/deposit-list')}}"  style="text-decoration: none;"> 
                                    <button type="button" class="btn btn-info btn-sm">
                                    <i class="fas fa-list-alt"></i> Deposit List</button>
                                </a>
                               
                                <a href="{{url('shoppers/'.$shopper->id.'/edit')}}" style="text-decoration: none;"> 
                                    <button type="button" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i></button>
                                </a>
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="deleteFunction({{$shopper->id}})">
                                    <i class="fas fa-trash"></i>
                                </button>
                               
                           </td>
                       </tr>
                       @endforeach
                   </tbody>
                  
                </table>
            </div>
            
        </div>
    </div>
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">
function deleteFunction(id) 
    {
        event.preventDefault();
        swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            confirmButtonColor: '#eea025',
            cancelButtonColor: '#b1abab',
        }).then((result) => {
            if(result.isConfirmed){
                window.location.href = 'shoppers/'+id+'/destroy';
            }
        })
    }
function search() 
{
    var word = document.getElementById('searchWord').value;
    var tableBody = document.getElementById('tableBody');
    tableBody.innerHTML = '';
    $.ajax({
        url:'{{route('search_customer')}}',
        type:'GET',
        data:{'word':word},
        success:function(data) {
            data.forEach(item => {
            tableBody.innerHTML += 
            '<tr>'+
            '<td>'+item.name+'</td>'+
            '<td>'+item.phone+'</td>'+
            '<td>'+item.address+'</td>'+
            '<td>'+item.fee+'</td>'+
            '<td><button type="button" class="btn btn-dark btn-sm" onclick="packageList('+item.id+')"><i class="fas fa-list-alt"></i> Package List</button>'+
                '<button type="button" class="btn btn-info btn-sm ml-2" onclick="depositList('+item.id+')"><i class="fas fa-list-alt"></i> Deposit List</button>'+
                '<button type="button" class="btn btn-success btn-sm ml-2" onclick="editFunction('+item.id+')"><i class="fas fa-edit"></i></button>'+
                '<button type="submit" class="btn btn-danger btn-sm ml-2" onclick="deleteFunction('+item.id+')"><i class="fas fa-trash"></i></button>'+
            '</td>'+
            '</tr>';
            })
        }
    })
}
function packageList(id)
{
    window.location.href = 'shoppers/'+id+'/package-list';
    var container = document.getElementById('myDiv');
    var content = container.innerHTML;
    container.innerHTML = content;
}
function depositList(id)
{
    window.location.href = 'shoppers/'+id+'/deposit-list';
    var container = document.getElementById('myDiv');
    var content = container.innerHTML;
    container.innerHTML = content;
}
function editFunction(id) 
{
    window.location.href = 'shoppers/'+id+'/edit';
    var container = document.getElementById('myDiv');
    var content = container.innerHTML;
    container.innerHTML = content;
}
</script>