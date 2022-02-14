@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                @if (isset($client))
                @foreach ($client as $client)
                    <form action="{{url ('clients/'.$client->id.'/package') }}" method="POST">
                    {{ csrf_field() }}
                {{ method_field('patch') }}
                        <div class="form-group">
                            <label for="name">Client Name</label>
                            <input type="text" name="name" class="form-control" placeholder="Enter Client Name" 
                            value="{{ $client->name }}" required >
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" class="form-control"  placeholder="Enter Email" 
                            value="{{ $client->email }}" required>
                        </div>
                   
                        <div class="form-group">
                            <label for="package">Total Package</label>
                            <input type="number" name="package" class="form-control" placeholder="Enter Total Package"
                            value="{{ $client->total_package }}"  required> 
                        </div>
                        <button class="btn btn-primary" id="update">Update</button>
                    </form>
                @endforeach
                @endif
               