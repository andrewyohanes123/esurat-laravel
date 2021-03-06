@extends('layouts.dashboard')

@section('title', 'Disposisi : ' . $dispositionRelation->disposition->reference_number)

{{-- {{ dd($dispositionRelation->from_user()->first()) }} --}}

@section('content')
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('disposition.' . $type) }}">Kembali</a></li>
    </ol>
    @component('components.card')
        @slot('title', $dispositionRelation->disposition->reference_number)
        @if (session('success'))

        @endif
        <div class="row justify-content-between">
          @if (Auth::user()->id === $dispositionRelation->disposition->from_user)
          <div class="col-md-12">
            <p class="text-muted m-0">Status : {{ $dispositionRelation->disposition->done ? 'Terverifikasi' : 'Belum diverifikasi' }}</p>
          </div>
          @endif
          <div class="col-md-4 my-2">
            <h5 class=" m-0"><span class="badge badge-primary badge-lg">{{ $dispositionRelation->from_user()->first()->name }}</span>
              <i class="fa fa-angle-right fa-md"></i>
              <span class="badge badge-success badge-lg">{{ $dispositionRelation->to_user()->first()->name }}</span>
            </h5>
          </div>
          <div class="col-md-6">
            <p class="text-muted text-right">Terkirim ke : {{ $dispositionRelation->disposition->lastUser->department->name }}</p>
          </div>
        </div>
        {{ $dispositionRelation->disposition->letter_type }}
        <h4 class="text-muted m-0">{{ $dispositionRelation->disposition->letterType()->get()->first()->name }}</h4>
        <code>{{ $dispositionRelation->disposition->letter_sort }}</code>
        <hr>
        <p class="text-justify m-0">{{ $dispositionRelation->disposition->description }}</p>
        @if (Auth::user()->department->name === 'Direktur')
          @php
              $id = $dispositionRelation->disposition->id;
          @endphp
          <form action="{{ route('disposition.verification', compact('type', 'id')) }}" class="form-inline" method="post">
            @method('PUT')
            @csrf
            <button type="submit" {{ $dispositionRelation->disposition->done ? 'disabled' : '' }} class="btn btn-outline-primary btn-sm mt-3"><i class="fa fa-check fa-md"></i>&nbsp;{{ $dispositionRelation->disposition->done ? 'Surat Terverifikasi' : 'Verifikasi Surat' }}</button>
          </form>
        @endif
        <hr>
        <label for="" class="control-label my-2">Pesan Disposisi dari {{ $dispositionRelation->disposition_message->user()->get()->first()->name }}</label>
        <textarea class="form-control" rows="10" style="resize: none" readonly>{{ $dispositionRelation->disposition_message->message }}</textarea>
        <hr>
        <p class="small text-muted my-2">Lampiran</p>
        @if (sizeof($dispositionRelation->disposition->letterFiles()->get()) === 0)
            <h5 class="my-2 d-inline-block"><span class="badge rounded-pill badge-dark p-2">Tidak ada lampiran</span></h5>
        @endif
        <div class="row">
          @foreach ($dispositionRelation->disposition->letterFiles()->get() as $file)
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
    @if (Auth::user()->department->permissions['forward.' . $type])
    @component('components.card')
        @slot('title', 'Kirim Disposisi Ke')
        <div class="row">
          <div class="col-md-6">
            <form action="{{ route('disposition.forward', ['type' => $type, 'id' => $dispositionRelation->id]) }}" method="POST" class="form-group">
                @csrf
                <select multiple name="to_user[]" id="" class="form-control @error('to_user') is-invalid @enderror">
                    <option disabled value="">-- Pilih pengguna --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->department->name }}</option>
                    @endforeach
                </select>
                @error('to_user')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <label for="" class="control-label my-2">Pesan Tambahan</label>
                <input type="hidden" value="{{ $dispositionRelation->disposition->id }}" name="disposition_id">
                <textarea name="message" id="" rows="7" class="form-control @error('message') is-invalid @enderror" placeholder="Pesan Disposisi"></textarea>
                @error('message')
                  <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <hr>
                <button class="btn btn-outline-success">Kirim</button>
            </form>
          </div>
        </div>
    @endcomponent
    @endif
@endsection
