@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <h5 class="text-center">Company Lists</h5>
                <a href="{{url('companies/create')}}">
                    <button class="btn btn-primary btn-sm float-right mb-2">
                        <i class="fa fa-plus-circle"></i> Add New
                    </button>
                </a>
                <table class="table table-bordered table.hover">
                    <thead>
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th>Company Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone Number</th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                        <tr>
                            {{-- <td>{{ $company -> id }}</td> --}}
                            <td>{{ $company -> name }}</td>
                            <td>{{ $company -> email }}</td>
                            <td>{{ $company -> address }}</td>
                            <td>{{ $company -> ph }}</td>
                            <td>
                                <button class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit</button>
                                <button clas class="btn btn-danger btn-sm"s=""> <i class="fa fa-trash"></i> Delete</button>
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