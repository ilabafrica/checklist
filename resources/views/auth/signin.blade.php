<!DOCTYPE html>
<html>
  <head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>{!! Lang::choice('messages.echecklist', 1) !!}</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- Bootstrap -->
      <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">
      <style type="text/css">
          .header{
              padding-top: 45px;
              padding-bottom: 15px;
              border-bottom: 1px solid #e5e5e5;
          }
          .footer{
              margin-top: 45px;
              padding-top: 15px;
              padding-bottom: 15px;
              border-top: 1px solid #e5e5e5;
              text-align: center;
          }
          #slmta-tagline {
              padding-right: 60px;
              padding-left: 60px;
              padding-top: 48px;
              padding-bottom: 48px;
              text-align: center;
              color: #303C45;
          }
          #slmta-tagline h1 {
              font-size: 50px;
          }
          #slmta-tagline p {
              font-size: 18px;
          }
          a.brand:hover {
              text-decoration: none;
          }
          .navbar + .container{
              margin-top:3em;
          }
      	</style>
    </head>
    <body>
    	<nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">{!! Lang::choice('messages.echecklist', 1) !!}</a>
              </div>
              <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                  <li><a href="#">{!! Lang::choice('messages.initiative', 1) !!}</a></li>
                </ul>
              </div><!--/.nav-collapse -->
            </div>
        </nav>
      	<div class="container">
          	<div class="header"></div>
      	<div id="slmta-tagline">
          	<p>{!! Lang::choice('messages.punch-line', 1) !!}</p>
      	</div>
      	<div class="row">
          	<div class="col-md-4"></div>
          	<div class="col-md-4">
          		@if (count($errors) > 0)
				    <div class="alert alert-danger">
				        <ul>
				            @foreach ($errors->all() as $error)
				                <li>{{ $error }}</li>
				            @endforeach
				        </ul>
				    </div>
				@endif
              	<form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
                  	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                  	<input type="text" class="form-control" autocomplete="off" autofocus="autofocus" name="username" placeholder="Username">
                  	<br>
                  	<input type="password" class="form-control" autocomplete="off" name="password" placeholder="Password">
                  	<br>
                  	<button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                  	<br>
                  	<p> Can't access your account? </p>
                  	<a class="btn btn-info btn-lg btn-block" href="{{ url('/password/email') }}">Reset your password.</a>
              	</form>
          	</div>
         	<div class="col-md-4"></div>
      	</div>
      	<footer class="footer"> 
        	<div class="container"> 
          		<p>
              		<a href="http://www.ilabafrica.ac.ke">About @iLabAfrica</a> | 
              		{!! date('Y') !!} {!! Lang::choice('messages.compiled-by', 1) !!}
          		</p>  
        	</div> 
      	</footer>
    	</div>
      	<script src="{{ URL::asset('admin/js/bootstrap.min.js') }}"></script>
  	</body>
</html>