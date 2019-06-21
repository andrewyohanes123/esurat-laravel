@extends('layouts.dashboard')

@section('title', $title . ' | ' . Auth::user()->name)

@section('content')
    @component('components.card')
        @slot('title')
        <i class="fa fa-{{ $icon }} fa-lg"></i>&nbsp;{{ $title }}
        @endslot
    @endcomponent
    {{-- {{ $dispositionRelations }} --}}
    @if (sizeof($dispositionRelations) === 0)
        <div class="card my-2">
            <div class="card-body"><h5 class="m-0 text-muted text-center">Belum ada disposisi</h5></div>
        </div>
    @endif
    @foreach ($dispositionRelations as $d)
        @component('components.disposition-card')
            @slot('title', $d->disposition->reference_number)
            @slot('id', $d->id)
            @slot('type', $type)
            <p class="text-muted m-0"><i class="fa fa-paper-plane fa-lg"></i>&nbsp;Dikirim ke : {{ $d->to_user()->first()->name }} dari : {{ $d->from_user()->first()->name }}</p>
            <h4 class="my-2"><span class="badge badge-danger">{{ $d->disposition->letterType()->get()->first()->name }}</span></h4>
            <p class="my-2">{{ Str::limit($d->disposition_message->message, 40) }}</p>
            <hr>
            <p class="m-0 text-muted">Lampiran</p>
            @if (sizeof($d->disposition->letterFiles()->get()) === 0)
                <h5 class="my-2 d-inline-block"><span class="badge rounded-pill badge-dark p-2">Tidak ada lampiran</span></h5>
            @endif
            @foreach ($d->disposition->letterFiles()->get() as $file)
                <h5 class="my-2 d-inline-block"><span class="badge rounded-pill badge-dark p-2">{{ Str::limit($file->file, 10) }}</span></h5>
            @endforeach
        @endcomponent
    @endforeach
@endsection
