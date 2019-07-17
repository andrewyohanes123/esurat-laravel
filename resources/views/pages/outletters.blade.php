@extends('layouts.dashboard')

@section('title', $title . ' | ' . Auth::user()->name)

@section('content')
    @component('components.card')
        @slot('title')
        <i class="fa fa-{{ $icon }} fa-lg"></i>&nbsp;{{ $title }}
        @endslot
    @endcomponent
    {{-- {{ $dispositionRelations }} --}}
    @if (sizeof($dispositions) === 0)
        <div class="card my-2">
            <div class="card-body"><h5 class="m-0 text-muted text-center">Belum ada surat keluar</h5></div>
        </div>
    @endif
    @foreach ($dispositions as $d)
        @component('components.outletter-card')
            @slot('title', $d->reference_number)
            @slot('id', $d->id)
            @slot('type', $type)
            <p class="text-muted m-0 d-block clearfix">
                {{-- <i class="fa fa-paper-plane fa-lg"></i>&nbsp;Dikirim dari : {{ $d->from_user()->first()->name }} ke : {{ $d->to_user()->first()->name }} --}}
                <p class="d-block m-0 text-muted float-right">{{ $d->letter_sort }}</p>
            </p>
            <h4 class="my-2">
                <span class="badge badge-danger">{{ $d->letterType()->get()->first()->name }}</span>                
            </h4>
            <p class="my-2">{{ Str::limit($d->description, 40) }}</p>
            <hr>
            <p class="m-0 text-muted">Lampiran</p>
            @if (sizeof($d->letterFiles()->get()) === 0)
                <h5 class="my-2 d-inline-block"><span class="badge rounded-pill badge-dark p-2">Tidak ada lampiran</span></h5>
            @endif
            @foreach ($d->letterFiles()->get() as $file)
                <h5 class="my-2 d-inline-block"><span class="badge rounded-pill badge-dark p-2"><a target="_blank" class="text-light" href="{{ Storage::url('attachments/' . $file->file) }}">{{ Str::limit($file->file, 10) }}</a></span></h5>
            @endforeach
        @endcomponent
    @endforeach
@endsection
