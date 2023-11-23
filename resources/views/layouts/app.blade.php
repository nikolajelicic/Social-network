<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <nav class="navbar navbar-expand-lg justify-content-end bg-secondary">
            <div class="container">
                <a class="navbar-brand" href="/">Social network</a>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav navbar-right main-menu">
                        <li class="nav-item">
                            <a href="/profile" class="nav-link">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="/neewsfeed" class="nav-link">Neewsfeed</a>
                        </li>
                        <li class="nav-item">
                            <a href="/add-friends" class="nav-link">Add friends</a>
                        </li>
                        <li class="nav-item">
                            <a href="/notification" class="nav-link">Notification</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
    
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    
        <!-- Page Content -->
        @yield('content')
    </body>
</html>