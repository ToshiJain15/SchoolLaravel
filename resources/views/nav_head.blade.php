<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.25/datatables.min.css"/>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
   
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> 
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet" defer>
</head>
<body>
@php
$location="http://localhost/example-app/public";                    
$class=\DB::table('exams')->where('class_id','=','1')->first('class_id');
@endphp
<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <ul class="navbar-nav mr-auto" style='list-style-type: none; text-indent: 90px'>
                             @if(Gate::allows('isAdmin'))
                            <li class="nav-item" style='float:left;'><a class="nav-link" href={{$location}}/list style='text-decoration:none;'>{{ __('Class List') }}</a></li>
                            <li class="nav-item" style='float:left;'><a class="nav-link" href={{$location}}/occupation style='text-decoration:none;'>{{ __('Occupation List') }}</a></li>
                            <li class="nav-item" style='float:left';><a class="nav-link" href={{$location}}/student style='text-decoration:none;'>{{ __('Student List') }}</a></li>
                            <li class="nav-item" style='float:left';><a class="nav-link" href={{$location}}/city style='text-decoration:none;'>{{ __('City List') }}</a></li>
                            <li class="nav-item" style='float:left';><a class="nav-link" href={{$location}}/subject style='text-decoration:none;'>{{ __('Subject List') }}</a></li>
                            @endif
                            @if(Gate::allows('isAdmin') || Gate::allows('isStudent'))
                            <li class="nav-item" style='float:left';><a class="nav-link" href={{$location}}/exam_list style='text-decoration:none;'>{{ __('Exam List') }}</a></li>
                            @foreach($class as $key => $val)
                                <li class="nav-item" style='float:left';><a class="nav-link"  href={{$location}}/exam/student/{{$val}} style='text-decoration:none;'>{{ __('Exam Student List') }}</a></li>
                            @endforeach
                            @endif
                            @if(Gate::allows('isAdmin') || Gate::allows('isManager'))
                            <li class="nav-item" style='float:left';><a class="nav-link" href={{$location}}/chart_list style='text-decoration:none;'>{{ __('Chart List') }}</a></li>
                            @endif
                            @if(Gate::allows('isAdmin'))
                            <li class="nav-item" style='float:left';><a class="nav-link" href={{$location}}/user_list style='text-decoration:none;'>{{ __('User List') }}</a></li>
                            @endif
                        </ul>
                            <ul class="navbar-nav ml-auto">
    <li style='float:left'; class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
    <!-- <li style='float:left';><a href="{{ url('/logout') }}" style='text-decoration:none;' class="dropdown-item">Logout</a></li> -->
    </ul><br><br>


</nav>

</body>
</html>
@yield('form')
<!-- 
$location="http://localhost/example-app/public";
$class=\DB::table('exams')->select('class_id')->get();
$rec=[];

    "<ul style='list-style-type: none; text-indent: 90px'>
    <li style='float:left;'><a href=$location/list style='text-decoration:none;'>Class List</a></li>
    <li style='float:left;'><a href=$location/occupation style='text-decoration:none;'>Occupation List</a></li>
    <li style='float:left';><a href=$location/student style='text-decoration:none;'>Student List</a></li>
    <li style='float:left';><a href=$location/city style='text-decoration:none;'>City List</a></li>
    <li style='float:left';><a href=$location/subject style='text-decoration:none;'>Subject List</a></li>
    <li style='float:left';><a href=$location/exam_list style='text-decoration:none;'>Exam List</a></li>";
    foreach($class as $key => $val){
    "<li style='float:left';><a href=$location/exam/student/{$val->class_id} style='text-decoration:none;'>Exam Student List</a></li></ul><br><br>",

    }
  <a href="http://localhost/example-app/public/logout" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="dropdown-item">
                                        Logout
                                    </a>  

?>   -->