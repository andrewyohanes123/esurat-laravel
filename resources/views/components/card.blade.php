<div class="card my-2">
  <div class="card-body">
    <div class="row justify-content-between">
      <div class="col-md-8">
        <h5 class="m-0">{{ $title }}</h5>        
      </div>
      @if (Route::currentRouteName() === 'disposition.in' || Route::currentRouteName() === 'disposition.out' || Route::currentRouteName() === 'outletter.index')
      <div class="col-md-3">
        <form action="" class="form-inline" method="get">
          <div class="input-group input-group-sm">
            <input type="text" value="{{ Request::get('key') }}" name="key" placeholder="Cari surat" class="form-control">
            <div class="input-group-append">
              <button class="btn btn-success"><i class="fa fa-search fa-lg"></i></button>
            </div>
          </div>
        </form>
      </div>
      @endif
    </div>
    <hr>
    {{ $slot }}
  </div>
</div>