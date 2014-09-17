<html>
	<head>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

        <link rel="stylesheet" href="<?php public_path(); ?>/assets/css/custom.css">

	</head>

    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button
                    type="button"
                    class="navbar-toggle collapsed"
                    data-toggle="collapse"
                    data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{{ URL::to('/games/pending') }}}">Bet Tracker</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    @if (Auth::check())
                    <li class="dropdown">
                        <a
                            href="#"
                            class="dropdown-toggle"
                            data-toggle="dropdown">
                            User <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Current Bets</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Profile</a></li>
                        </ul>
                    </li>
                    <li><a href="{{{ URL::to('/users/logout') }}}">Logout</a></li>
                    @else
                    <li><a href="{{{ URL::to('/users/create') }}}">Register</a></li>
                    <li><a href="{{{ URL::to('/users/login') }}}">Login</a></li>
                    @endif
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <body>
        <div class="container">
            @yield('content')
        </div>
    </body>
    <footer>
    	<script src="<?php public_path(); ?>/assets/js/jquery-2.1.1.min.js"></script>

    	<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </footer>
</html>