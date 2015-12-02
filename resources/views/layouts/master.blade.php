<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>TU/e posters</title>
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        <!-- Bootstrap -->
        <link href="{{ asset('bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        
        <!-- Datepicker -->
        <link rel="stylesheet" href="{{ asset('plugins/datepicker/datepicker3.css') }}">
        
        <!-- Dropzone -->
        <link rel="stylesheet" href="{{ asset('plugins/dropzone/dropzone.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/dropzone/style.css') }}">
        
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="{{ asset('plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
        <!-- Dropzone.js -->
        <script src="{{ asset('plugins/dropzone/dropzone.js') }}"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
        <!-- Datepicker -->
        <script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
        <!-- Readmore.js -->
        <script src="{{ asset('plugins/readmore-js/readmore.js') }}"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <nav class="navbar navbar-inverse">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{{ route('poster.list') }}">TU/e posters</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    @if (Auth::check())
                        <div class="navbar-form navbar-right">
                        <a href="{{ route('auth.logout') }}" class="btn btn-primary">Logout</a>
                        </div>
                    @else
                        {!! Form::open([
                            'method' => 'POST', 
                            'route' => 'auth.login',
                            'class' => 'navbar-form navbar-right'
                        ]) !!}
                            {!! Form::token() !!}
                            
                            <div class="form-group">
                                {!! Form::text('username', Input::old('username'), ['class' => 'form-control', 'placeholder' => 'Username']) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                            </div>
                            
                            {!! Form::submit('Login', ['class' => 'btn btn-primary']) !!}
                        </form>
                    @endif
                </div><!--/.navbar-collapse -->
            </div>
        </nav>
        <div class="container">
            <section class="content-header">
                @yield('header')
                @yield('breadcrumbs')
            </section>
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        @if (Session::has('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {{ Session::get('error') }}
                        </div>
                        @endif
                        @if (Session::has('alert'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {{ Session::get('alert') }}
                        </div>
                        @endif
                        @if (Session::has('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {{ Session::get('success') }}
                        </div>
                        @endif
                        @if (Session::has('info'))
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            {{ Session::get('info') }}
                        </div>
                        @endif
                        
                        
                        
                        @yield('content')
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>

