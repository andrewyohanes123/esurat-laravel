@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('content')
<div class="card">
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <h5 class="m-0">Selamat datang, {{ Auth::user()->name }}</h5>
        <hr>
        <div class="row">
            @if(Auth::user()->role === 'administrator')
            <div class="col-md-4">
                <div class="card border-0 text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column justify-content-left">
                                <h4 class="my-2">Pengguna</h4>
                                <a href="{{ route('user.index') }}" class="btn btn-light"><i class="fa fa-angle-right fa-lg"></i></a>
                            </div>
                            <h1 class="d-block m-0">{{ $users }}</h1>
                        </div>
                    </div>
                </div>
            </div>
            @elseif(Auth::user()->role === 'employee')
                <div class="col-md-4">
                    <div class="card border-0 text-white bg-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column justify-content-left">
                                    <h4 class="my-2">Disposisi Masuk</h4>
                                    <h1 class="my-1"><i class="fa fa-inbox fa-2x"></i></h1>
                                </div>
                                <h1 class="d-block m-0">{{ $in }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 text-white bg-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex flex-column justify-content-left">
                                    <h4 class="my-2">Disposisi Keluar</h4>
                                    <h1 class="my-1"><i class="fa fa-boxes fa-2x"></i></h1>
                                </div>
                                <h1 class="d-block m-0">{{ $out }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
