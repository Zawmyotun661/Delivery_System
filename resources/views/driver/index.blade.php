@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <div class="row mb-3">
                <h5>Driver Lists</h5>
                    <div class="col-md-6 mx-auto">
                            <div class="input-group" id="myDiv">
                                <input class="form-control border-end-0 border" type="search" id="name" placeholder="Filter By Driver Name or Mail" value="{{$search_value}}">
                                <span class="input-group-append">
                                    <button class="btn btn-outline-secondary bg-white border-start-0 border ms-n5" id="search">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                    </div>
                </div>
                <a href="{{url('drivers/create')}}">
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
                <table class="table table-bordered table.hover">
                    <thead>
                        <tr>
                            <th>Driver Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Contact Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="table_body">
                        @foreach($drivers as $driver)
                        <tr>
                            <td>{{ $driver ->name }}</td>
                            <td>{{ $driver->email }}</td>
                            <td>{{ $driver ->address }}</td>
                            <td>{{ $driver ->phone }}</td>
                            <td>
                                <a href="{{url('drivers/'.$driver->user_id.'/edit')}}" style="text-decoration: none;">
                                    <button class="btn btn-success btn-sm"><i class="fa fa-edit"></i></button>
                                </a>
                                    <a href="{{url('drivers/'.$driver->user_id.'/destroy')}}">
                                        <button class="btn btn-danger btn-sm" onclick="deleteFunction({{$driver->user_id}})"> <i class="fa fa-trash"></i></button>
                                    </a>
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
        // if(search_value != ''){
        //     alert('a');
        // }
        $('#search').on('click', function(){
            var query = $('#name').val();
            var tableBody = document.getElementById('table_body');
            tableBody.innerHTML = '';
            $.ajax({
                url:'{{route('search')}}',
                type:'GET',
                data:{'name':query},
                success:function(data) {
                    console.log(data)
                    data.forEach(item => {
                    tableBody.innerHTML += 
                    '<tr>'+
                    '<td>'+item.name+'</td>'+
                    '<td>'+item.email+'</td>'+
                    '<td>'+item.address+'</td>'+
                    '<td>'+item.phone+'</td>'+
                    '<td><button type="button" class="btn btn-success btn-sm" onclick="editFunction('+item.user_id+')">'+
                    '<i class="fa fa-edit"></i></button>'+
                    '<button clas class="btn btn-danger btn-sm ml-2" onclick="deleteFunction('+item.user_id+')"> <i class="fa fa-trash"></i></button></td>'+
                    '</tr>';
                    })
                }
            })
        }); 
    });
    //Edit
    function editFunction(userId) {
        window.location.href = 'drivers/'+userId+'/edit';
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
            window.location.href = 'drivers/'+id+'/destroy';
        }
    })
}
    </script>
@endsection