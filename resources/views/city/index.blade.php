<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
 integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" 
 integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" 
 crossorigin="anonymous" referrerpolicy="no-referrer" />


    <title>City</title>
    <style> 
    body{
        padding: 50px;
    }
</style>
</head>
<body>
    <div class="container">
        <div class="row">
            
            <div class="col-md-12">
                <h5 class="text-center">Cities</h5>
                <a href="{{url('city/create')}}">
                    <button class="btn btn-primary btn-sm float-right mb-2">
                        <i class="fa fa-plus-circle"></i> Add New
                    </button>
                </a>
                <table class="table table-bordered table.hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>City Name</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($city as $city)
                        <tr>
                            <td>{{ $city -> id }}</td>
                            <td>{{ $city -> name }}</td>
                           
                            <td>
                                <button class="btn btn-success btn-sm"><i class="fa fa-edit"></i> Edit</button>
                            
                                <button clas class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> Delete</button>
                            </td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>


<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" 
integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body>
</html>