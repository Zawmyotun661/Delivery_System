@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
            <h5>Client Lists</h5>
                <div class="row mb-3">
                     <div class="col-md-6 mx-auto">
                            <div class="input-group" id="myDiv">
                                <input class="form-control border" type="search" id="name"
                                 placeholder="Search Client" value="" style="border-radius: 3px;">
                                <div class="pl-5">
                                    <button class="btn btn-primary border px-2" id="search" 
                                    style="width: 130px; padding:10px; border-radius:20px">
                                        <i class="fa fa-search">  Search</i>
                                    </button>
                                </div>
                            </div>
                    </div>
                </div>
                {{-- <h5 class="pb-3 pt-3 text-center">Client Lists</h5> --}}
                 <a href="{{url('clients/create')}}">
                    <button class="btn btn-primary btn-sm  mb-2">
                        <i class="fa fa-plus-circle"></i> Add New
                    </button>
                </a> 
                @if(Session('successAlert'))
                <div class="alert alert-success alert-dismissible show fade">
                    <strong>{{Session('successAlert')}}</strong>
                    <button class="close" data-dismiss="alert">&times;</button>
                </div>
                @endif
                <table class="table table-bordered table.hover">
                    <thead>
                        <tr>
                            <th>Client Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Contact Number</th>
                            <th>Total Package</th>
                            <th>Total Created Package</th>
                          
                           
                            <th>Update Package</th>
                            <th>Update Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach($clients as $client)
                        <tr>
                            <td>{{ $client -> name }}</td>
                            <td>{{ $client -> email }}</td>
                            <td>{{ $client -> address }}</td>
                            <td>{{ $client -> phone }}</td>
                            <td>{{ $client -> total_package }}</td>
                            <td>{{ $client -> created_pack }}</td>
                            <td>{{ $client -> updated_at }}</td>
                            <td>
                                <a href="{{url('clients/'.$client->id.'/edit_package')}}" style="text-decoration: none;">
                                    <button type="button" class="btn btn-primary btn-sm">
                                        <i class="fa fa-edit"></i> </button>
                                    </a>
                               
                            </td>
                            <td>
                                <a href="{{url('clients/'.$client->id.'/edit')}}" style="text-decoration: none;">
                                    <button type="button" class="btn btn-success btn-sm">
                                        <i class="fa fa-edit"></i> </button>
                                    </a>
                                <button clas class="btn btn-danger btn-sm" onclick="deleteFunction({{$client->id}})"> <i class="fa fa-trash"></i> </button>
                            </td>
                        
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        var search_value = document.getElementById('name').value;
    
        $('#search').on('click', function(){
            var query = $('#name').val();
            var tableBody = document.getElementById('tbody');
            tableBody.innerHTML = '';
            $.ajax({
                url:'{{route('search_client')}}',
                type:'GET',
                data:{'name':query},
                success:function(data) {
                    data.forEach(item => {
                    tableBody.innerHTML += 
                    '<tr>'+
                    '<td>'+item.name+'</td>'+
                    '<td>'+item.email+'</td>'+
                    '<td>'+item.address+'</td>'+
                    '<td>'+item.phone+'</td>'+
                    '<td>'+item.total_package+'</td>'+
                    '<td>'+item.created_pack+'</td>'+
                    '<td><button type="button" class="btn btn-success btn-sm" onclick="editFunction('+item.id+')">'+
                    '<i class="fa fa-edit"></i></button>'+
                    '<button clas class="btn btn-danger btn-sm ml-2" onclick="deleteFunction('+item.id+')"> <i class="fa fa-trash"></i></button></td>'+
                    '</tr>';
                    })
                }
            })
        }); 
    });

    function editFunction(id)
    {
        window.location.href = 'clients/'+id+'/edit';
        var container = document.getElementById('myDiv');
        var content = container.innerHTML;
        container.innerHTML = content;
    }
    
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
                window.location.href = 'clients/'+id+'/destroy';
            }
        })
    }
    </script>
    @endsection