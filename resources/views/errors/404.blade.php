<!-- Page not found error page -->
<html>
	<head>
		<link href="{{ URL::asset('admin/css/error-font.css') }}" rel="stylesheet">
		<link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">
		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 100;
				font-family: 'Lato';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 72px;
				margin-bottom: 40px;
			}
			.back{
				margin-left: auto;
				margin-right: auto;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title">Be right back.</div>
				<div class="row">
    				<div class="col-lg-12">
						<a class="btn btn-primary" href="" onclick="window.history.back();return false;">
	                		<h4><i class="fa fa-reply"></i><span> {{ Lang::choice('messages.back', 1) }}</span></h4>
	            		</a>
	            	</div>
	            </div>
			</div>

		</div>
	</body>
</html>
