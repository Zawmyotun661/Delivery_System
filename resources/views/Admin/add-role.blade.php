@extends('dashboardTemplate')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <h5>Manage Role</h5>
                <form action="{{url('admin/'.$user->id.'/update')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" value="{{ $user->name }}">
                    </div>
                    <h5>Roles</h5>
                    @foreach ( $roles as $role)
                    <div>
                        <input type="checkbox" id="label{{$role->id}}" value="{{$role->id}}" name="role_ids[]"
                        @foreach($user->roles as $userRole)
                        @if ($userRole->name == $role->name)
                            checked
                        @endif
                        @endforeach>
                        <label for="label{{$role->id}}">{{$role->name}}</label>
                    </div>
                    @endforeach
                    <br>
                    <button class="btn" style="background:  #928DAB;">Add Role</button>
                </form>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
@endsection
