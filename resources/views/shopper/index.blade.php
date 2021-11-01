
@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
            <h5 class="mb-5">Customer Lists</h5>
                {{-- <h5 class="text-center">Customer</h5> --}}
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
                            <th>Customer Name</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Payable Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($shopper as $shopper)
                       <tr>
                           <td >{{ $shopper -> name }}</td>
                           <td >{{ $shopper -> phone }}</td>
                           <td >{{ $shopper -> address }}</td>
                           <td>{{ $shopper->toget }}</td>
                           <td>
                               {{-- <form action="{{url('shoppers/'.$shopper->id)}}" method="POST">
                               @csrf
                               @method('DELETE') --}}
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
                               {{-- </form> --}}
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
        // alert(id);
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
</script>