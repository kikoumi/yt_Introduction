<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Youtube-share</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script type="application/javascript" async src="https://www.googletagmanager.com/gtag/js?id=UA-158124848-1"></script>
    <script type="application/javascript" src="https://kit.fontawesome.com/b1783bcf7c.js" crossorigin="anonymous"></script>
    <script type="application/javascript">
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-158124848-1');
    </script>



    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tagsinput.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    Youtube-share(仮)
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="トグルナビゲーション">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @if (isset(auth()->user()->role))
                        @if(auth()->user()->role == 'owner')
                        <ul class="navbar-nav mr-auto">
                            <li class="{{ Request::is('tags/*') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('tags.index') }}">タグ</a>
                            </li>
                        </ul>
                        @endif
                    @endif


                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a href="{{ route('channel.index')}}" class="nav-link">チャンネル一覧</a>
                            </li>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">ログイン</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">新規登録</a>
                                </li>
                            @endif
                        @else
                            <li>
                            <a href="/mypage" class="nav-link">マイページ</a>
                            </li>
                            <li>
                                <a href="/mylikes" class="nav-link">いいね
                                    <i class="far fa-heart  LikesIcon-fa-heart" style="color:#333;  cursor : pointer;"></i>
                                </a>
                            </li>
                            <li>
                            <a href="{{ route('channel.index')}}" class="nav-link">チャンネル一覧</a>
                            </li>
                            <li class="nav-item">
                            <a href="{{ route('posts.create') }}" class="nav-link">動画登録</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        ログアウト
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
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
</body>
</html>
