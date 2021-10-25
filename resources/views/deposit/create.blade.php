@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{url ('shoppers/'.$id.'/create-deposit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="date"> Date</label>
                        <input type="date" name="date" class="form-control"  placeholder="Enter Date" 
                        value="{{  old('date')}}" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Deposit Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter Deposit Amount" 
                        value="{{ old('amount')}}" required >
                    </div>
                   <button class="btn btn-primary">Create</button>
                    
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
@endsection