<ul class="nav flex-column">
  <li class="nav-item"><a href="{{ route('user.index') }}" class="nav-link {{ Route::currentRouteName() === 'user.index' ? 'active' : '' }}"><i class="fa fa-users fa-lg"></i>&nbsp;Pengguna</a></li>
  <li class="nav-item"><a href="{{ route('tipe-surat.index') }}" class="nav-link  {{ Route::currentRouteName() === 'tipe-surat.index' ? 'active' : '' }}"><i class="fa fa-envelope fa-lg"></i>&nbsp;Tipe Surat</a></li>
  <li class="nav-item"><a href="#" class="nav-link"><i class="fa fa-mail-bulk fa-lg"></i>&nbsp;Semua Disposisi</a></li>
</ul>