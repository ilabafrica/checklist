<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ Config::get('slipta.name') }}</title>

    <!-- Font awesome css -->
    <link rel="stylesheet" href="{{ URL::asset('css/font-awesome.min.css') }}">

    <!-- Bootstrap Core CSS -->
    <link href="{{ URL::asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ URL::asset('admin/css/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ URL::asset('admin/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Datatables -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/css/dataTables.bootstrap.css') }}" />
    <!-- Datepicker -->
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('admin/css/datepicker.css') }}" />
    
    <script src="{{ URL::asset('admin/js/jquery.min.js') }}"></script>

    <!-- Posabsolute jQuery Validation -->
    <link href="{{ URL::asset('admin/css/validationEngine.jquery.css') }}" rel="stylesheet">

</head>

<body>         
        <div id="page-wrapper">
            @yield('content')
        <hr>
        <p>{!! date('Y') !!} {!! Lang::choice('messages.compiled-by', 1) !!}</p>
        </div>    
    <!-- /#wrapper -->
    
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ URL::asset('admin/js/bootstrap.min.js') }}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{ URL::asset('admin/js/metisMenu.min.js') }}"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="{{ URL::asset('admin/js/jquery.dataTables.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('admin/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ URL::asset('admin/js/moment.js') }}"></script>
    <script src="{{ URL::asset('admin/js/bootstrap-datepicker.js') }}"></script>
    <!-- Posabsolute jQuery validation -->
    <script src="{{ URL::asset('admin/js/jquery.validationEngine-en.js') }}"></script>
    <script src="{{ URL::asset('admin/js/jquery.validationEngine.js') }}"></script>
    <script src="{{ URL::asset('admin/js/sb-admin-2.js') }}"></script>
</body>

</html>
