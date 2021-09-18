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


    <title>Package Lists</title>
    <style> 
    body{
        padding: 100px;
    }
</style>
</head>
<body>
    <div class="container">
        <div class="row">
          
            <div class="col-md-12">
                <h5 class="text-center">Package Lists</h5>
                <a href="{{url('packages/create')}}">
                    <button class="btn btn-primary btn-sm  mb-2">
                        <i class="fa fa-plus-circle"></i> Add New
                    </button>
                </a>
                @if(Session('successAlert'))
                    <div class="alert alert-secondary alert-dismissible show fade">
                        <strong>{{Session('successAlert')}}</strong>
                       

                    </div>
                @endif
                <table class="table table-bordered table.hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Package Name</th>
                            <th>Package Size</th>
                            <th>Package Type</th>
                           <th>Country </th>
                           <th>City </th>
                           <th>Township </th>
                            <th>Actions</th>

                        </tr>
                    </thead>
                    <tbody>
                       
                        @foreach($packages as $package)

                        <tr>
                            <td>{{ $package -> id }}</td>
                            <td>{{ $package -> package_name }}</td>
                            <td>{{ $package -> package_size }}</td>
                            <td>{{ $package -> package_type }}</td>
                            <td>{{ $package -> country }}</td>
                            <td>{{ $package -> city }}</td>
                            <td>{{ $package -> township }}</td>
                            
                         
                            <td>
                                <form action="{{url('packages/'.$package->id)}}" method="POST">
                                @method('DELETE')
                                     @csrf
                                <a href="{{url('packages/'.$package->id.'/edit')}}">
                                <button type="button" class="btn btn-success btn-sm">
                                    <i class="fa fa-edit"></i> Edit</button>
                                </a>
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm ('Are you sure want to Delete?')"> 
                                    <i class="fa fa-trash"></i> Delete</button>
                                </form>
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