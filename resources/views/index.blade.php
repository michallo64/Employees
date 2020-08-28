@extends('adminlte::page')

@section('title', 'Employees')

@section('content_header')
    <h1>List of employees</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                Create employee
            </button>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="authors" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Sex</th>
                    <th>Age</th>
                    <th>Action</th>
                </tr>
                </thead>
                @if(!$employees->isEmpty())
                    @foreach($employees as $employee)
                        <tr>
                            <td>{{$employee->name}}</td>
                            <td>{{$employee->sex}}</td>
                            <td>{{$employee->age}}</td>
                            <td><a href="{{route('employee.edit', $employee->id)}}"
                                   class="btn btn-info">Edit</a> ||
                                <a href="{{route('employee.delete', $employee->id)}}"
                                   class="btn btn-danger"
                                   id="delete">Delete</a></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="4">No data to display.</td>
                    </tr>
                @endif
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Create new employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{route('employee.create')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="age">Age</label>
                                    <input type="number" class="form-control" id="age" name="age">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sex">Sex</label>
                                    <select id="sex" class="custom-select" name="age">
                                        <option selected disabled>Select one</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">Create</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
