@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
            <div class="row mb-3">
            <h5>Township Lists</h5>
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
                <a href="{{url('township/create')}}">
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
                            <th>Township Name</th>
                            {{-- <th>Action</th> --}}
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @foreach($township as $township)
                        <tr>
                            <td>{{ $township -> name }}
                                <button class="btn btn-danger btn-sm float-right" onclick="deleteFunction({{$township->id}})"> <i class="fa fa-trash"></i> </button>
                            </td>
                                {{-- <td> --}}
                                    
                                {{-- </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                url:'{{route('search_township')}}',
                type:'GET',
                data:{'name':query},
                success:function(data) {
                    data.forEach(item => {
                    tableBody.innerHTML += 
                    '<tr>'+
                    '<td>'+item.name+'<button clas class="btn btn-danger btn-sm ml-2 float-right" onclick="deleteFunction('+item.id+')"> <i class="fa fa-trash"></i></button></td>'+
                    '</tr>';
                    })
                }
            })
        }); 
    }); 

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
                window.location.href = 'township/'+id+'/destroy';
            }
        })
    }  
</script>
@endsection