<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                        @php
                        $location=url('/');                    
                        $class=\DB::table('exams')->where('class_id','=','1')->first('class_id');
                        @endphp
                        <!-- <ul style='list-style-type: none; text-indent: 90px'> -->
                            <li class="nav-item" style='float:left;'><a class="nav-link" href="{{ url('list') }}" style='text-decoration:none;'>{{ __('Class List') }}</a></li>
                            <li class="nav-item" style='float:left;'><a class="nav-link" href="{{ url('occupation') }}" style='text-decoration:none;'>{{ __('Occupation List') }}</a></li>
                            <li class="nav-item" style='float:left';><a class="nav-link" href="{{ url('student') }}" style='text-decoration:none;'>{{ __('Student List') }}</a></li>
                            <li class="nav-item" style='float:left';><a class="nav-link" href="{{ url('city') }}" style='text-decoration:none;'>{{ __('City List') }}</a></li>
                            <li class="nav-item" style='float:left';><a class="nav-link" href="{{ url('subject') }}" style='text-decoration:none;'>{{ __('Subject List') }}</a></li>
                            <li class="nav-item" style='float:left';><a class="nav-link" href="{{ url('exam_list') }}" style='text-decoration:none;'>{{ __('Exam List') }}</a></li>
                            @foreach($class as $key => $val)
                                <li class="nav-item" style='float:left';><a class="nav-link"  href="{{ url('exam/student/'.$val) }}" style='text-decoration:none;'>{{ __('Exam Student List') }}</a></li>
                            @endforeach
                            <li class="nav-item" style='float:left';><a class="nav-link" href="{{ url('chart_list') }}" style='text-decoration:none;'>{{ __('Chart List') }}</a></li>
                            <li class="nav-item" style='float:left';><a class="nav-link" href="{{ url('user_list') }}" style='text-decoration:none;'>{{ __('User List') }}</a></li>
                            <li class="nav-item dropdown">
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
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
