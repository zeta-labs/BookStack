<!DOCTYPE html>
<html>
<head>
    <title>BookStack</title>

    <!-- Meta-->
    <meta name="viewport" content="width=device-width">
    <meta name="token" content="{{ csrf_token() }}">
    <meta charset="utf-8">

    <!-- Styles and Fonts -->
    <link rel="stylesheet" href="{{ elixir('css/styles.css') }}">
    <link rel="stylesheet" media="print" href="{{ elixir('css/print-styles.css') }}">
    <link href='//fonts.googleapis.com/css?family=Roboto:400,400italic,500,500italic,700,700italic,300italic,100,300' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="/bower/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="/bower/jquery-sortable/source/js/jquery-sortable.js"></script>

    @yield('head')
</head>
<body class="@yield('body-class')" id="app">

    @if(Session::has('success'))
        <div class="notification anim pos">
            <i class="zmdi zmdi-mood"></i> <span>{{ Session::get('success') }}</span>
        </div>
    @endif

    <div class="notification anim pos hidden" id="notification-success">
        <i class="zmdi zmdi-mood"></i> <span class="text"></span>
    </div>

    @if(Session::has('error'))
        <div class="notification anim neg stopped">
            <i class="zmdi zmdi-alert-circle"></i> <span>{{ Session::get('error') }}</span>
        </div>
    @endif

    <div class="notification anim neg stopped hidden" id="notification-error">
        <i class="zmdi zmdi-alert-circle"></i> <span class="text"></span>
    </div>

    <header id="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <a href="/" class="logo">
                        @if(Setting::get('app-logo', '') !== 'none')
                            <img class="logo-image" src="{{ Setting::get('app-logo', '') === '' ? '/logo.png' : Setting::get('app-logo', '') }}" alt="Logo">
                        @endif
                        <span class="logo-text">{{ Setting::get('app-name', 'BookStack') }}</span>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-3 text-center">
                    <form action="/search/all" method="GET" class="search-box">
                        <input id="header-search-box-input" type="text" name="term" tabindex="2" value="{{ isset($searchTerm) ? $searchTerm : '' }}">
                        <button id="header-search-box-button" type="submit" class="text-button">@icon('search')</button>
                    </form>
                </div>
                <div class="col-lg-4 col-sm-5">
                    <div class="float right">
                        <div class="links text-center">
                            <a href="/books">@icon('book')Books</a>
                            @if($currentUser->can('settings-update'))
                                <a href="/settings">@icon('settings')Settings</a>
                            @endif
                            @if(!$signedIn)
                                <a href="/login">@icon('sign-in')Sign In</a>
                            @endif
                        </div>
                        @if($signedIn)
                            <div class="dropdown-container" data-dropdown>
                                <span class="user-name" data-dropdown-toggle>
                                    <img class="avatar" src="{{$currentUser->getAvatar(30)}}" alt="{{ $currentUser->name }}">
                                    <span class="name">{{ $currentUser->name }}</span> <span class="large">@icon('caret-down')</span>
                                </span>
                                <ul>
                                    <li>
                                        <a href="/users/{{$currentUser->id}}" class="text-primary">@icon('edit')Edit Profile</a>
                                    </li>
                                    <li>
                                        <a href="/logout" class="text-neg">@icon('logout')Logout</a>
                                    </li>
                                </ul>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="content" class="block">
        @yield('content')
    </section>

@yield('bottom')
<script src="{{ elixir('js/common.js') }}"></script>
</body>
</html>
