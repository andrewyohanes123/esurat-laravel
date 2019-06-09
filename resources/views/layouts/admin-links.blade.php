<ul class="nav flex-column">
  <li class="nav-item"><a href="{{ route('home') }}" class="nav-link {{ Route::currentRouteName() === 'home' ? 'active' : '' }}"><i class="fa fa-tachometer-alt fa-lg"></i>&nbsp;Dashboard</a></li>
  <li class="nav-item"><a href="{{ route('user.index') }}" class="nav-link {{ Route::currentRouteName() === 'user.index' ? 'active' : '' }}"><i class="fa fa-users fa-lg"></i>&nbsp;Pengguna</a></li>
  <li class="nav-item"><a href="{{ route('tipe-surat.index') }}" class="nav-link  {{ Route::currentRouteName() === 'tipe-surat.index' ? 'active' : '' }}"><i class="fa fa-envelope fa-lg"></i>&nbsp;Tipe Surat</a></li>
  <li class="nav-item"><a href="{{ route('privilleges') }}" class="nav-link {{ Route::currentRouteName() === 'privilleges' ? 'active' : '' }}"><i class="fa fa-check-square fa-lg"></i>&nbsp;Hak Akses</a></li>
</ul>
