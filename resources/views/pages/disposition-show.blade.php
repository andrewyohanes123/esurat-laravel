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
        <h5 class=" m-0"><span class="badge badge-primary badge-lg">{{ $dispositionRelation->from_user()->first()->name }}</span>
          <i class="fa fa-angle-right fa-md"></i>
        <span class="badge badge-success badge-lg">{{ $dispositionRelation->to_user()->first()->name }}</span>
        {{ $dispositionRelation->disposition->letter_type }}
        </h5>
        <h4 class="text-muted m-0">{{ $dispositionRelation->disposition->letterType()->get()->first()->name }}</h4>
        <p class="text-justify m-0">{{ $dispositionRelation->disposition->description }}</p>
        <hr>
        <label for="" class="control-label my-2">Pesan Disposisi dari {{ $dispositionRelation->disposition_message->user()->get()->first()->name }}</label>
        <textarea class="form-control" style="resize: none" readonly>{{ $dispositionRelation->disposition_message->message }}</textarea>
        <hr>
        <p class="small text-muted m-0">Lampiran</p>
        @if (sizeof($dispositionRelation->disposition->letterFiles()->get()) === 0)
            <h5 class="my-2 d-inline-block"><span class="badge rounded-pill badge-dark p-2">Tidak ada lampiran</span></h5>
        @endif
        <div class="row">
          @foreach ($dispositionRelation->disposition->letterFiles()->get() as $file)
              <div class="col-md-2">
                <div class="card border-0 shadow-sm">
                  <img src="{{ Storage::url('attachments/' . $file->file) }}" class="card-img-top" alt="">
                  @if ($file->name !== '')
                    <div class="card-body p-1">{{ $file->name }}</div>
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
            <form action="{{ route('disposition.forward', ['type' => $type, 'id' => $dispositionRelation->disposition->id]) }}" method="POST" class="form-group">
                @csrf
                <select name="to_user" id="" class="form-control @error('to_user') is-invalid @enderror">
                    <option value="">-- Pilih pengguna --</option>
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
