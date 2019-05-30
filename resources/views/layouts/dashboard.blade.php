<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
  <nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand p-2 col-sm-3 col-md-2 mr-0" href="#">e-Surat</a>
    <ul class="navbar-nav px-3">
      <li class="nav-item text-nowrap"><a href="#" class="nav-link">Logout</a></li>
    </ul>
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
          @endif
        </div>
      </nav>
      <main class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div style="height: 70px;"></div>
        @yield('content')
      </main>
    </div>
  </div>
</body>
</html>