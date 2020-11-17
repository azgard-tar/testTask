<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/bower_components/admin-lte/dist/css/adminlte.min.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body>
    @include('html_parts/top')
    <div class="container-fluid" style="height: 80vh">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-4">
                <div class="col-sm-6">
                    <h1>Login</h1>
                </div>

                <form role="form" id="quickForm" novalidate="novalidate" method="GET" action="/login">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="inputEmail">Email address</label>
                            <input type="email" name="email" class="form-control email" id="inputEmail" placeholder="Enter email">
                        </div>
                        <div class="form-group">
                            <label for="inputPassword">Password</label>
                            <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
                @isset( $error )
                <div class="alert alert-danger" role="alert">
                    {{ $error }}
                </div>
                @endisset
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="/bower_components/admin-lte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/bower_components/admin-lte/dist/js/adminlte.min.js"></script>
    <script src="/bower_components/admin-lte/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="/bower_components/admin-lte/plugins/jquery-validation/additional-methods.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#quickForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    }
                },
                messages: {
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a vaild email address"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
</body>

</html>