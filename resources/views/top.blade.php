<style>
    .thisNav{
        position: relative;
        z-index: 10;
        background-color: rgba(80,80,80,0.5);
    }
</style>

<nav class="fixed-top navbar navbar-expand thisNav">
    <ul class="navbar-nav">
        <li class="nav-item text-white ml-3">
            <h3> Test task </h1>
        </li>
    </ul>
    @unless( ! Auth::check() )
    <ul class=" navbar-nav ml-auto">
        <li class="nav-item mt-2">
            <h4>
                <a href="logout">
                    <i class="fa fa-sign-out text-secondary"></i>
                </a>
            </h4>
        </li>
    </ul>
    @endunless
</nav>