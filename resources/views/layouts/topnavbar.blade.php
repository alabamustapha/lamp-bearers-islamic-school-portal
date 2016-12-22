<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            <!-- <form role="search" class="navbar-form-custom" method="post" action="/">
                <div class="form-group">
                    <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search" />
                </div>
            </form> -->
        </div>
        @if(Auth::user())
            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <span class="m-r-sm text-info welcome-message">Current Session: {{ $session->name or "No session is active" }}</span>
                </li>
                <li>
                    <span class="m-r-sm text-info welcome-message">Current Term: {{ $session ? $session->term() : "No session is active"}}</span>
                </li>
                {{--<li>--}}
                    {{--<span class="m-r-sm text-muted welcome-message">Last login {{ Auth::user()->last_login->diffForHumans() }}</span>--}}
                {{--</li>--}}
                <li>
                    <a href="{{ url('/logout') }}">
                        <i class="fa fa-sign-out"></i> Log out
                    </a>
                </li>
            </ul>
        @endif
    </nav>
</div>
