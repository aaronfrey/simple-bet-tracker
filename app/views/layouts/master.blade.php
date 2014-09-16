<html>
	<head>
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

        <link rel="stylesheet" href="<?php public_path(); ?>/assets/css/custom.css">

	</head>
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