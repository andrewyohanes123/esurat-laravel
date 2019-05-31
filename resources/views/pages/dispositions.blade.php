@extends('layouts.dashboard')

@section('title', 'Disposisi Masuk | ' . Auth::user()->name)

@section('content')
    @component('components.card')
        @slot('title')
        <i class="fa fa-inbox fa-lg"></i>&nbsp;Disposisi Masuk
        @endslot
        @foreach (unserialize($setting->users_allow_create_disposition) as $user)
            @if ($user === Auth::user()->department_id)
              <a href="#" class="btn btn-outline-success btn-sm">Buat Surat</a>
            @endif
        @endforeach
    @endcomponent
@endsection