@extends('layouts.dashboard')

@section('title', 'Disposisi Masuk | ' . Auth::user()->name)

@section('content')
    @component('component.card')
        @slot('title')
            Disposisi Masuk
        @endslot
    @endcomponent
@endsection