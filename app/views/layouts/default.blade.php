<!doctype html>
<html lang="en">
<head>
	
	<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
	{{ HTML::script('js/include_map.js') }}
	@include('includes.head')
	@section('title')
		<title>Technowell Traffic</title>
	@show
</head>
<body>
	<div class="container-fluid">
		<header class="row">
			@include('includes.header')
		</header>
		<div id="main">
			@yield('content')
		</div>
		<!-- <footer class="row">
			@include('includes.footer')
		</footer> -->
	</div>	
</body>
</html>