<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    @include('top')
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
                            <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter email">
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
    <script type="text/javascript">
    $(document).ready(function () {
    $.validator.setDefaults({
        submitHandler: function () {
            alert( "Form successful submitted!" );
        }
    });
    $('#quickForm').validate({
        rules: {
        email: {
            required: true,
            email: true,
        },
        password: {
            required: true,
            minlength: 5
        },
        terms: {
            required: true
        },
        },
        messages: {
        email: {
            required: "Please enter a email address",
            email: "Please enter a vaild email address"
        },
        password: {
            required: "Please provide a password",
            minlength: "Your password must be at least 5 characters long"
        },
        terms: "Please accept our terms"
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        }
    });
    });
    </script>
</body>
</html>