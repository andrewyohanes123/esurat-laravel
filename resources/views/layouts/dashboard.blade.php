<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="user-token" content="{{ Auth::user()->api_token }}" />
</head>
<body>
  <nav class="navbar navbar-dark fixed-top bg-primary flex-md-nowrap p-0 shadow">
    <a class="navbar-brand p-2 col-sm-3 col-md-2 mr-0" href="#">e-Surat</a>
    <ul class="navbar-nav ml-auto">
        @if (Auth::user()->role === 'employee')
        <li class="nav-item dropdown text-nowrap px-3">
            <a href="javascript:void(0)" class="nav-link"><i class="fa fa-bell fa-lg dropdown-toggle" data-toggle="dropdown"></i></a>
            <div class="dropdown-menu">
                <a href="#" class="dropdown-item">Testing</a>
            </div>
        </li>
        @endif
        <li class="nav-item text-nowrap px-3">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
        </li>
    </ul>
    {{-- </div> --}}
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
  </nav>
  <div class="container-fluid">
    <div class="row">
      <nav class="col-md-2 d-none d-md-block bg-light sidebar">
        <div class="sidebar-sticky">
          <ul class="nav flex-column">
            <li class="nav-item">
              <a href="#" class="m-0 nav-link">
                <h5>{{ Auth::user()->name }}
                <p class="m-0 text-muted small">{{ Auth::user()->department->name }}</p></h5>
              </a>
            </li>
          </ul>
          <hr>
          @if (Auth::user()->role === 'administrator')
            @include('layouts.admin-links')
          @elseif(Auth::user()->role === 'employee')
            @include('layouts.user-links')
          @endif
        </div>
      </nav>
      <main class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div style="height: 70px;"></div>
        @yield('content')
      </main>
    </div>
  </div>
  <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
