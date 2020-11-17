<link rel="stylesheet" href="/bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css">
<style>
    .thisNav {
        position: relative;
        z-index: 10;
        background-color: rgba(80, 80, 80, 0.5);
    }
</style>

<nav class="fixed-top navbar navbar-expand thisNav">
    <ul class="navbar-nav">
        <li class="nav-item text-white ml-3">
            <h3> Test task </h3>
        </li>
    </ul>
    @if( Auth::check() )
    <ul class="navbar-nav ml-auto">
        <li class="nav-item mt-2">
            <h4>
                <a href="/logout">
                    <i class="nav-icon fas fa-sign-out-alt text-secondary"></i>
                </a>
            </h4>
        </li>
    </ul>
    @endif
</nav>