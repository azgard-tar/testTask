<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add position</title>
    <link rel="stylesheet" href="/bower_components/admin-lte/dist/css/adminlte.min.css">
</head>

<body>
    @include('sidebar')
    <div class="content-wrapper w-25">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Add position</h1>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <div class="card card-primary">
            <form role="form" method=POST enctype=multipart/form-data> <div class="card-body">
                @csrf
                <div class="form-group">
                    <label for="inputTitle">Title</label>
                    <input type="text" name="title" class="form-control" id="inputTitle" placeholder="Enter title">
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a type="submit" class="btn btn-secondary" href="/positions">Cancel</a>
                </div>
                @if( count( $errors ) > 0 )
                    <div class="alert alert-danger" role="alert">
                        {{ json_encode($errors,true) }}
                    </div>
                @endif
            </form>
            
        </div>
    </div>

    <script src="/bower_components/admin-lte/dist/js/adminlte.min.js"></script>
    <script src="/bower_components/admin-lte/plugins/jquery/jquery.min.js"></script>
    <script src="/bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>