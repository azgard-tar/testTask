<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit position</title>
    <link rel="stylesheet" href="/bower_components/admin-lte/dist/css/adminlte.min.css">
</head>

<body>
    @include('sidebar')
    <div class="content-wrapper w-50">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit position</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <div class="card card-primary">
            <form role="form" method=POST enctype=multipart/form-data> <div class="card-body">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="inputTitle">Title</label>
                    <input type="text" value="{{ $position->title }}" name="title" class="form-control" id="inputTitle" placeholder="Enter title">
                </div>
                <div class="container-fluid">
                <div class="row">
                    <div class="col">
                        <a class="btn btn-secondary btn-block" href="/positions">Cancel</a>
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </div>
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

        <table class="table">
            <tr>
                <th style="width:50%">Created_at:</th>
                <td>{{ $position->created_at ?? ""}}</td>
            </tr>
            <tr>
                <th>Updated_at</th>
                <td>{{ $position->updated_at ?? ""}}</td>
            </tr>
            <tr>
                <th>Admin_created_id:</th>
                <td>{{ $position->admin_created_id ?? ""}}</td>
            </tr>
            <tr>
                <th>Admin_updated_id:</th>
                <td>{{ $position->admin_updated_id ?? ""}}</td>
            </tr>
        </table>
    </div>
    <script src="/bower_components/admin-lte/dist/js/adminlte.min.js"></script>
    <script src="/bower_components/admin-lte/plugins/jquery/jquery.min.js"></script>
    <script src="/bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>