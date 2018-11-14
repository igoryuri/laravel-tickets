<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- CSRF Token -->
    {{--<meta name="_token" content="{{ csrf_token() }}">--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Metro 4 -->
    <link href="{{ asset('css/metro-all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    @yield('styles')

</head>
<body>
    @guest
        <div class="shifted-content-2 h-100 p-ab">
            <div class="bg-black z-1" data-role="appbar">
                <div class="offset-10">
                    <div class="row flex-align-end">
                        <a class="app-bar-item fg-white" href="{{ route('login') }}">{{ __('Login') }}</a>
                        <a class="app-bar-item fg-white" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </div>
                </div>

            </div>
            <div class="h-100 p-2">
                <main class="py-2">
                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <aside class="sidebar pos-absolute z-2"
               data-role="sidebar"
               data-toggle="#sidebar-toggle-1"
               id="sb4"
               data-shift=".shifted-content"
               data-static-shift=".shifted-content">
            <div class="sidebar-header bg-dark">
                <div class="avatar bg-cyan text-bold text-upper">
                    <h3 class="pt-3">
                        @php
                            $partes = explode(".",Auth::user()->username);$ret = '';foreach($partes as $parte) if(strlen($parte) > 3) $ret .= substr($parte,0,1);
                            echo $ret;
                        @endphp
                    </h3>
                </div>
                <span class="title fg-white">{{ Auth::user()->name }}</span>
                <span class="subtitle fg-white"> 2018 © Bioclin - Quibasa</span>
            </div>
            <ul class="sidebar-menu">
                <li {{\AppHelper::checkAcessToButton('home')}}><a href="{{ route('home') }}"><span class="mif-home icon"></span>Home</a></li>
                <li {{\AppHelper::checkAcessToButton('tickets.index')}}><a href="{{ route('tickets.index') }}"><span
                                class="mif-credit-card icon"></span>Tickets</a></li>
                <li {{\AppHelper::checkAcessToButton('users.index')}}><a href="{{ route('users.index') }}"><span
                                class="mif-users icon"></span>Users</a></li>
                <li {{\AppHelper::checkAcessToButton('routes.index')}}><a href="{{ route('routes.index') }}"><span class="mif-compass2 icon"></span>Rotas</a>
                </li>
                <li {{\AppHelper::checkAcessToButton('departments.index')}}><a href="{{ route('departments.index') }}"><span
                                class="mif-library icon"></span>Departments</a></li>
                <li {{\AppHelper::checkAcessToButton('permissions.index')}}><a href="{{ route('permissions.index') }}"><span
                                class="mif-unlock icon"></span>Permissions</a></li>
                <li {{\AppHelper::checkAcessToButton('categories.index')}}><a href="{{ route('categories.index') }}"><span
                                class="mif-versions icon"></span>Categories</a></li>
                <li class="divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <span class="mif-exit icon"></span>{{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </aside>
        <div class="shifted-content h-100 p-ab">

            <div class="app-bar pos-absolute bg-dark z-1" data-role="appbar">

                <button class="app-bar-item c-pointer ml-5" id="sidebar-toggle-1">
                    <span class="mif-menu fg-white"></span>
                </button>

                <a href="{{ route('home') }}" class="app-bar-item c-pointer fg-white" {{\AppHelper::checkAcessToButton('home')}}>Dashboard</a>

                <div class="app-bar-container ml-auto order-3 order-md-4 fg-white mr-5">
                    <div class="app-bar-container">
                        {{--Begin Menu Notification--}}
                        <a href="#" class="dropdown-toggle" id="dropdown_toggle_1">
                            <span class="mif-bell icon"></span>
                            <span class="badge inside">{{ Auth::user()->unreadNotifications->count()}}</span>
                        </a>
                        <ul class="v-menu place-right items-list" data-role="dropdown" data-toggle-element="#dropdown_toggle_1">
                            <li class="item">
                                <a class="dropdown-item" href="{{ route('monitorings.readed') }}">
                                    Marca como lidas
                                    <span class="mif-cancel icon fg-blue mx-2"></span>
                                </a>
                            </li>
                            @foreach( Auth::user()->unreadNotifications as $notification )
                                <li class="item">
                                    <a class="dropdown-item"
                                       href="{{ route('monitorings.showPage', ['monitoring' => $notification->data['ticket_id'],'notId' => $notification->id])}}">
                                        {{$notification->data['message']}}
                                        <span class="mif-mail-read icon mx-2"></span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        {{--End Menu Notification--}}
                    </div>

                    <div class="app-bar-container">
                        {{--Begin Menu User--}}
                        <a href="#" class="dropdown-toggle" id="dropdown_toggle_2">
                            <span class="mif-user icon mr-1"></span>
                            {{Auth::user()->name}}
                        </a>
                        <ul class="v-menu place-right items-list" data-role="dropdown" data-toggle-element="#dropdown_toggle_2">
                            <li class="item">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                    <span class="mif-exit icon mx-2"></span>
                                </a>
                            </li>
                        </ul>
                        {{--End Menu User--}}
                    </div>
                </div>

            </div>

            <div class="h-100 p-4">
                <main>
                    @yield('content')
                </main>
            </div>
        </div>
    @endguest
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="{{ asset('js/metro.js') }}" defer></script>
    @yield('scripts')
</body>
</html>
