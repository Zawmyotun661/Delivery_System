@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-7">
            <h5 class="mb-4">Deposit Lists</h5>
                <a href="{{url('shoppers/'.$id.'/new-deposit')}}">
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
                            <th>Date</th>
                            <th>Deposit Amount</th>
                            <th>Remark</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($deposits as $deposit)
                       <tr>
                           <td >{{ $deposit -> date }}</td>
                           <td >{{ $deposit -> amount }}</td>
                           <td >{{ $deposit -> remark }}</td>
                           <td>
                                <a href="{{url('shoppers/'.$id.'/'.'deposit/'.$deposit->id.'/edit')}}" style="text-decoration: none;"> 
                                    <button type="button" class="btn btn-success btn-sm">
                                    <i class="fas fa-edit"></i></button>
                                </a>
                                {{-- <a href="{{url('shoppers/'.$id.'/'.'deposit/'.$deposit->id.'/destroy')}}" style="text-decoration: none;"> --}}
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                    onclick="deleteFunction({{$deposit->id}})">
                                    <i class="fas fa-trash"></i>
                                </button>
                            {{-- </a> --}}
                           </td>
                       </tr>
                       @endforeach
                   </tbody>
                  
                </table>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">
function deleteFunction(depoId) 
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
                window.location.href = 'deposit/'+depoId+'/destroy';
            }
        })
    }
</script>