@extends('dashboardTemplate')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form action="{{url ('shoppers/'.$deposit->shopper_id.'/'.'deposit/'.$deposit->id.'/update') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="date"> Date</label>
                        <input type="date" name="date" class="form-control"  placeholder="Enter Date" 
                        value="{{ $deposit->date ?? old('date')}}" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Deposit Amount</label>
                        <input type="number" name="amount" class="form-control" placeholder="Enter Deposit Amount" 
                        value="{{ $deposit->amount ?? old('amount')}}" required >
                    </div>
                   <button class="btn btn-primary" id="update">Save</button>
                    
                </form>
            </div>
            <div class="col-md-3"></div>
        </div>
    </div>
@endsection
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    document.getElementById("update").addEventListener('click', function(e){
        e.preventDefault();
        var form = $(this).parents('form');
        swal.fire({
            title: 'Are you sure?',
            text: "You want to save this changes!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, save it!',
            confirmButtonColor: '#eea025',
            cancelButtonColor: '#b1abab',
        }).then((result) => {
            if(result.isConfirmed){
                form.submit();
            }
        });
    });
});
</script>