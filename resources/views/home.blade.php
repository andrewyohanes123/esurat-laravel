@extends('layouts.dashboard')

@section('title', 'Dashboard')
@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header">Dashboard</div>
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            {{ Auth::user()->department->name }}
    </div>
</div>
@endsection
