<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('/bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet" />
    <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" />
    <link href="{{ asset('/bower_components/admin-lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('/bower_components/admin-lte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('/bower_components/admin-lte/dist/css/adminlte.min.css')}}" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet" />
    <title> List of employees </title>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        @include('sidebar')
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Employees</h1>
                        </div>
                        <div class="col-sm-6 d-flex flex-row-reverse">
                            <a class="btn btn-primary" href="/employees/add" role="button">Add employee</a>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Employees</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Photo</th>
                                                <th>Full name</th>
                                                <th>Position</th>
                                                <th>Date of employment</th>
                                                <th>Phone number</th>
                                                <th>Email</th>
                                                <th>Salary</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach( $employees as $employee )
                                            <tr>
                                                <td><img alt="Avatar" class="table-avatar img-size-50 mr-3 img-circle" src="<?php echo asset("storage/images/$employee->photo") ?>"></td>
                                                <td>{{ $employee->full_name }}</td>
                                                <td>{{ $employee->title }}</td>
                                                <td>{{ date(Config::get('app.date_format'), strtotime(  $employee->date_of_employment ) ) }}</td>
                                                <td>{{ $employee->phone_number }}</td>
                                                <td>{{ $employee->email }}</td>
                                                <td>{{ $employee->salary }}</td>
                                                <td>
                                                    <ul class="list-inline">
                                                        <li class="list-inline-item">
                                                            <a class="mr-4" href="/employees/edit/{{$employee->id}}">
                                                                <i class="fa fa-pen text-primary"></i>
                                                            </a>
                                                        </li>
                                                        <li class="list-inline-item">
                                                            <a data-toggle="modal" data-target="#myModal" data-id="{{$employee->id}}" data-name="{{$employee->full_name}}">
                                                                <i class="fa fa-trash-alt text-danger"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Remove employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <a id="modal-btn" class="btn btn-primary" role="button">Remove</a>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset ('/bower_components/admin-lte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset ('/bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset ('/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset ('/bower_components/admin-lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset ('/bower_components/admin-lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset ('/bower_components/admin-lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset ('/bower_components/admin-lte/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset ('/bower_components/admin-lte/dist/js/demo.js') }}"></script>
    <script>
        var el;
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
            });
        });
        $('#myModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var recipient = button.data('name');
            var modal = $(this)
            el = button.parents('tr');
            modal.find('.modal-body').text('Are you sure you want to remove employee ' + recipient + 
            '? Head of subordinates will be setted as defaul value(null).')
            modal.find('#modal-btn').attr('href', '/employees/delete/' + button.data('id'))
        });
    </script>
</body>

</html>