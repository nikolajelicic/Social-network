<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <script src="{{ asset('js/app.js') }}"></script>
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <nav class="navbar navbar-expand-lg justify-content-end bg-secondary">
            <div class="container">
                <a class="navbar-brand" href="/">Social network</a>
                <div class="collapse navbar-collapse visible">
                    <ul class="navbar-nav navbar-right main-menu">
                        <li class="nav-item">
                            <a href="/profile" class="nav-link">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a href="/friend-posts" class="nav-link">Friend posts</a>
                        </li>
                        <li class="nav-item">
                            <a href="/add-friends" class="nav-link">Add friends</a>
                        </li>
                        <li class="nav-item">
                            <a href="/notification" class="nav-link">Notification</a>
                        </li>
                        <li class="nav-item">
                            <a href="/chat" class="nav-link">Message</a>
                        </li>
                        <li class="nav-item">
                            <input type="text" id="searchInput" placeholder="Search users by name">
                            <ul id="searchResults"></ul>
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

        <!-- #likesModal-->
        <div class="modal fade" id="likesModal" tabindex="-1" aria-labelledby="likesModal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit message</h1>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    <form action="{{ route('profile.editMessage') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <ul class="list-group" id="likes">
                            
                            </ul>
                        </div>
                    </form>
                </div>
            </div>
      </div>

       <!-- #editPictureModal-->
      <div class="modal fade" id="editPictureModal" tabindex="-1" role="dialog" aria-labelledby="editPictureModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Edit profile image</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('profile.updateImage') }}" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-6">
                            <input id="image" type="file" class="form-control" name="image">
                        </div>
                    </div>
                    <button class="btn btn-primary">Save changes</button>
                </form>
            </div>
            <div class="modal-footer">
              <button class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    </body>
</html>