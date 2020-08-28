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
                    @foreach($fillables as $fillable)
                        <th>{{ucfirst($fillable)}}</th>
                    @endforeach
                    <th>Action</th>
                </tr>
                </thead>
                @if(!$employees->isEmpty())
                    @foreach($employees as $employee)
                        <tr>
                            @foreach($fillables as $attribute)
                                <td>{{$employee[$attribute]}}</td>
                            @endforeach

                            <td>
                                <button class="btn btn-info" data-toggle="modal" data-target="#modal-second"
                                        onclick="fill({{$employee->id}})">Edit
                                </button>
                                ||
                                <a href="{{route('employee.delete', $employee->id)}}"
                                   class="btn btn-danger"
                                   id="delete">Delete</a></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="{{count($fillables)+1}}">No data to display.</td>
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
                                    <select id="sex" class="custom-select" name="sex">
                                        <option selected disabled>Select one</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <select id="position" class="custom-select" name="position">
                                        <option selected disabled>Select one</option>
                                        <option value="CEO">CEO</option>
                                        <option value="Technician">Technician</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <div class="modal fade" id="modal-second">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{route('employee.edit')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="id" name="id" value="">
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
                                    <select id="sex" class="custom-select" name="sex">
                                        <option selected disabled>Select one</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="position">Position</label>
                                    <select id="position" class="custom-select" name="position">
                                        <option selected disabled>Select one</option>
                                        <option value="CEO">CEO</option>
                                        <option value="Technician">Technician</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>

    <!-- /.modal-dialog -->
@endsection

@section('js')
    <script>
        function fill(id) {
            $.ajax({
                type: "POST",
                url: "employee/" + id,
                data: {
                    _token: "{{ csrf_token() }}",
                },
            }).done(function (msg) {
                data = $.parseJSON(msg)['@attributes']
                $.each(data, function (i, item) {
                    $("#modal-second").find("#" + i).val(item)
                })
            })
        }
        $(function () {
            @if(Session::has('message'))
            var type = "{{Session::get('alert-type','info')}}"
            switch (type) {
                case 'info':
                    toastr.info("{{ Session::get('message') }}");
                    break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
            @endif
        })
    </script>

@endsection
