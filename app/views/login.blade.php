<!DOCTYPE html>

<html class="login">
  <head>
    <meta charset="UTF-8">
    <title>CAS | Login</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="{{ asset('adminlte/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet"/>
    <!-- Ionicons -->
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />

    <link href="{{ asset('adminlte/dist/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('adminlte/dist/css/skins/skin-purple.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

	<!--jQuery-->
	<script type="text/javascript" src="{{ asset('adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
	
  </head>
 
  <body>
    <div>
      <div>
        <section class="content login">
            <div class="login-box">
			  <div class="login-logo">
				<b>CAS </b>Login
			  </div>
			  <div class="login-box-body">
			  <p class="login-box-msg">Sign in to start your session</p>
				<div>
					@if ($errors->has())
						<div class="alert alert-danger">
							@foreach ($errors->all() as $error)
								{{ $error }}<br>        
							@endforeach
						</div>
					@elseif(Session::has('success'))
						<div class="alert alert-success">
							<a href="#" class="close" data-dismiss="alert">&times;</a>
							{{ Session::get('success') }}
						</div>
					@elseif(Session::has('fail'))
						<div class="alert alert-danger">
							<a href="#" class="close" data-dismiss="alert">&times;</a>
							{{ Session::get('fail') }}
						</div>
					@elseif (Session::has('message'))
						<div class='bg-danger alert'>{{ Session::get('message') }}</div>
					@endif            
				</div><!-- /.col -->
				
				{{ Form::open(['url' => '/check','method' => 'POST']) }}
				  <div class="form-group has-feedback">	
						<input class="form-control" type="email" id="email" name="email" placeholder="Email" required/>
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
				  </div>
				  <div class="form-group has-feedback">
						<input class="form-control" name="password" id="password" type="password" placeholder="Password" required/>
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
				  </div>
				  <div class="row">
				  	<div class="col-xs-8 form-group has-feedback">
							<label style="font-weight: normal;"><input name="remember" type="checkbox" /> Remember me</label>
					  </div>
						<div class="col-xs-4 pull-right text-right">
					  	<button type="submit" class="btn btn-primary">Login</button>
						</div>
				  </div>
				{{ Form::close() }}
				<p class="text-center">- OR -</p>
				<a href="{{ URL::to('register') }}" class="text-center">Register a new membership</a>
			  </div>
			</div>
        </section>
      </div>
    </div>
    <link href="{{ asset('dist/css/style.css') }}" rel="stylesheet" type="text/css">
  </body>
</html>