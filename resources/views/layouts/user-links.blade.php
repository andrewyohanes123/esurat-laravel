<ul class="nav flex-column">
    <li class="nav-item"><a href="{{ route('home') }}" class="nav-link {{ Route::currentRouteName() === 'home' ? 'active' : '' }}"><i class="fa fa-tachometer-alt fa-lg"></i>&nbsp;Dashboard</a></li>
    @foreach ($setting->users_allow_create_disposition as $dept)
        @if ($dept === Auth::user()->department_id)
          <li class="nav-item"></li><a href="{{ route('disposition.create') }}" class="nav-link {{ Route::currentRouteName() === 'disposition.create' ? 'active' : '' }}"><i class="fa fa-envelope-open fa-lg"></i>&nbsp;Buat Surat</a>
        @endif
    @endforeach
    <li><hr></li>
    <span class="sidebar-heading text-muted px-3">Surat Masuk</span>
    <li class="nav-item"><a href="{{ route('disposition.in') }}" class="nav-link {{ Route::currentRouteName() === 'disposition.in' ? 'active' : '' }}"><i class="fa fa-inbox fa-lg"></i>&nbsp;Disposisi Masuk</a></li>
    <li class="nav-item"><a href="{{ route('disposition.out') }}" class="nav-link {{ Route::currentRouteName() === 'disposition.out' ? 'active' : '' }}"><i class="fa fa-boxes fa-lg"></i>&nbsp;Disposisi Keluar</a></li>
    @foreach ($setting->users_allow_create_outbox as $dept)
    @if ($dept === Auth::user()->department_id)
    <li><hr></li>
            <span class="sidebar-heading text-muted px-3">Surat Keluar</span>
            <li class="nav-item"><a href="{{ route('outletter.create') }}" class="nav-link {{ Route::currentRouteName() === 'outletter.create' ? 'active' : '' }}"><i class="fa fa-mail-bulk fa-lg"></i>&nbsp;Buat Surat Keluar</a></li>
            <li class="nav-item"><a href="{{ route('outletter.index') }}" class="nav-link {{ Route::currentRouteName() === 'outletter.index' ? 'active' : '' }}"><i class="fa fa-envelope fa-lg"></i>&nbsp;Surat Keluar</a></li>
        @endif
    @endforeach
</ul>
