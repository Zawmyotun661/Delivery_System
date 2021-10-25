@extends('dashboardTemplate')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-10">
            <div class="row mb-3">
              <div class="col-md-6 mx-auto">
                <form action="{{ url('search_users') }}" method="GET">
                  @csrf
                  <div class="input-group">
                      <input class="form-control border-end-0 border" value="{{ isset($searchData) ? $searchData: '' }}" type="search" name="search_data" id="search_value" placeholder="Search User">
                      <span class="input-group-append">

                              <button class="btn btn-primary border ml-5 px-2" id="search" 
                                    style="width: 130px; padding:10px; border-radius:20px">
                                        <i class="fa fa-search">  Search</i>
                                    </button>
                      </span>
                  </div>
                </form>
               
              </div>
          </div>
          {{-- <h5 >Users</h5> --}}
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        {{-- <th>ID</th> --}}
                        <th>Name</th>
                        <th>Mail</th>
                        <th>Roles</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        {{-- <td>{{$user->id}}</td> --}}
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>
                        @foreach ($user->roles as $role)
                           <span class="badge" style="background:#1F1C2C ;">{{$role->name}}</span>
                        
                        @endforeach
                    </td>
                        <td><a href="{{url('admin/'.$user->id.'/manage-role')}}" style="background: #928DAB;" class="btn btn-sm">Manage Roles</a></td>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

