<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel='icon' type='image/x-icon' href='favicon.ico' />
    <title>Employee edit</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="/bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="/bower_components/admin-lte/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="/bower_components/admin-lte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/bower_components/admin-lte/dist/css/adminlte.min.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/bower_components/admin-lte/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition sidebar-mini">
    @include('sidebar')
    <div class="container-fluid">
        <div class="row">
            <div class="content-wrapper col-sm">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Edit employee</h1>
                            </div>
                        </div>
                    </div><!-- /.container-fluid -->
                </section>

                <div class="card card-primary">
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" method=POST enctype=multipart/form-data> <div class="card-body">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="inputFile">Photo</label>
                            <img alt="Avatar" class="table-avatar img-size-50 mr-3 img-circle" src="<?php echo asset("storage/images/$employee->photo") ?>">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="photo" class="custom-file-input" id="inputFile">
                                    <label class="custom-file-label" for="inputFile">Choose file</label>
                                </div>
                                <div class="input-group-append">
                                    <span class="input-group-text">Upload</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputFullName">Full name</label>
                            <input type="text" name="full_name" value="{{ $employee->full_name }}" class="form-control" id="inputFullName" placeholder="Enter full name">
                        </div>
                        <div class="form-group">
                            <label for="inputPhone">Phone</label>
                            <input type="text" name="phone_number" value="{{ $employee->phone_number }}" class="form-control" id="inputPhone" placeholder="Enter phone">
                        </div>
                        <div class="form-group">
                            <label for="inputEmail">Email</label>
                            <input type="email" name="email" value="{{ $employee->email }}" class="form-control" id="inputEmail" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label>Positions</label>
                            <select class="form-control select2" name="id_position" style="width: 100%;">
                                @foreach( $positions as $position )
                                @if( $position->id == $employee->id_position )
                                <option value="{{ $position->id }}" selected="selected">{{ $position->title }}</option>
                                @else
                                <option value="{{ $position->id }}">{{ $position->title }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="inputSalary">Salary</label>
                            <input type="number" name="salary" value="{{ $employee->salary }}" class="form-control" id="inputSalary" placeholder="Enter salary">
                        </div>
                        <div class="form-group">
                            <label>Head</label>
                            <select class="form-control select2" name="id_head" style="width: 100%;">
                                @if( is_null( $employee->id_head ) )
                                <option selected="selected" value="-1">none</option>
                                @else
                                <option value="-1">none</option>
                                @endif
                                @foreach( $employees as $employee1 )
                                @if( $employee1->id == $employee->id_head )
                                <option selected="selected" value="{{ $employee1->id }}">{{ $employee1->full_name }}</option>
                                @else
                                <option value="{{ $employee1->id }}">{{ $employee1->full_name }}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Date:</label>
                            <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                <input type="text" value="{{ $employee->date_of_employment }}" 
                                data-date-format="{{ Config::get('app.date_format_javascript') }}" 
                                data-provide="datepicker" 
                                name="date_of_employment" 
                                class="form-control datetimepicker-input" 
                                data-target="#reservationdate" />
                                <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a class="btn btn-secondary" href="/employeesList">Cancel</a>
                </div>
                @if( count( $errors ) > 0 )
                <div class="alert alert-danger" role="alert">
                    @foreach( $errors as $error )
                        {{ $error[0] }}<br/>
                    @endforeach
                </div>
                @endif
                </form>
            </div>
        </div>
        <div class="col-sm">
            <table class="table">
                <tr>
                    <th style="width:50%">Created_at:</th>
                    <td>{{ $employee->created_at ?? ""}}</td>
                </tr>
                <tr>
                    <th>Updated_at</th>
                    <td>{{ $employee->updated_at ?? ""}}</td>
                </tr>
                <tr>
                    <th>Admin_created_id:</th>
                    <td>{{ $employee->admin_created_id ?? ""}}</td>
                </tr>
                <tr>
                    <th>Admin_updated_id:</th>
                    <td>{{ $employee->admin_updated_id ?? ""}}</td>
                </tr>
            </table>
        </div>
    </div>
    <!-- /.card -->

    </div>
    <script src="/bower_components/admin-lte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/bower_components/admin-lte/plugins/select2/js/select2.full.min.js"></script>
    <script src="/bower_components/admin-lte/plugins/daterangepicker/daterangepicker.js"></script>
    <script src="/bower_components/admin-lte/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/bower_components/admin-lte/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/bower_components/admin-lte/dist/js/demo.js"></script>
    <script src="/js/bootstrap-datepicker.js"></script>
    <!-- Summernote -->
    <script src="/bower_components/admin-lte/plugins/summernote/summernote-bs4.min.js"></script>
    <script>
        $(function() {
            // Summernote
            $('.select2').select2()
        })
    </script>
</body>

</html>