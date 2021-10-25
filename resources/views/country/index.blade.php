@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-10">
                <h5 class="text-center">Countries</h5>
                <a href="{{url('country/create')}}">
                    <button class="btn btn-primary btn-sm float-right mb-2">
                        <i class="fa fa-plus-circle"></i> Add New
                    </button>
                </a>
                <table class="table table-bordered table.hover">
                    <thead>
                        <tr>
                            {{-- <th>ID</th> --}}
                            <th>Country Name</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($country as $country)
                        <tr>
                            {{-- <td>{{ $country -> id }}</td> --}}
                            <td>{{ $country -> name }}</td>
                            <form action="{{ url('country/'.$country->id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <td>
                                    <button clas class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete?')"> <i class="fa fa-trash"></i> Delete</button>
                                </td>
                            </form>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>

@endsection