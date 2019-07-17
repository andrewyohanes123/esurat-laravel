@extends('layouts.dashboard')

@section('title', 'Disposisi : ' . $disposition->reference_number)

{{-- {{ dd($dispositionRelation->from_user()->first()) }} --}}

@section('content')
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('outletter.index') }}">Kembali</a></li>
    </ol>
    @component('components.card')
        @slot('title', $disposition->reference_number)
        @if (session('success'))

        @endif
        <h4 class="text-muted m-0">{{ $disposition->letterType()->get()->first()->name }}</h4>
        <code>{{ $disposition->letter_sort }}</code>
        <hr>
        <p class="text-justify m-0">{{ $disposition->description }}</p>
        <p class="small text-muted my-2">Lampiran</p>
        @if (sizeof($disposition->letterFiles()->get()) === 0)
            <h5 class="my-2 d-inline-block"><span class="badge rounded-pill badge-dark p-2">Tidak ada lampiran</span></h5>
        @endif
        <div class="row">
          @foreach ($disposition->letterFiles()->get() as $file)
              <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-primary">
                  @if ($file->type !== 'application/pdf')
                    <a target="_blank" href="{{ Storage::url('attachments/' . $file->file) }}"><img src="{{ Storage::url('attachments/' . $file->file) }}" class="card-img-top" alt=""></a>
                  @endif
                  @if ($file->name !== '')
                    <div class="card-body {{ $file->type !== 'application/pdf' ? 'p-1 text-white' : 'p-3' }}">
                      @if ($file->type !== 'application/pdf')
                      {{ $file->name }}
                      @else
                      <a target="_blank" class="text-white" href="{{ Storage::url('attachments/' . $file->file) }}">{{ $file->name }}</a>
                      @endif
                    </div>
                  @endif
                </div>
              </div>
          @endforeach
        </div>
    @endcomponent
@endsection
