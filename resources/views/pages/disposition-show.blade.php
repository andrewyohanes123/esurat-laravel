@extends('layouts.dashboard')

@section('title', 'Disposisi : ')

@section('content')
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('disposition.' . $type) }}">Kembali</a></li>
    </ol>
    @component('components.card')
        @slot('title', $disposition->reference_number)
        <h5 class=" m-0"><span class="badge badge-primary badge-lg">{{ $disposition->dispositionRelation->from_user()->first()->name }}</span> 
          <i class="fa fa-angle-right fa-md"></i> 
        <span class="badge badge-success badge-lg">{{ $disposition->dispositionRelation->to_user()->first()->name }}</span>
        {{ $disposition->letter_type }}
        </h5>
        <h4 class="text-muted m-0">{{ $disposition->letterType()->get()->first()->name }}</h4>
        <p class="text-justify m-0">{{ $disposition->description }}</p>
        <hr>
        <label for="" class="control-label my-2">Pesan Disposisi</label>
        <textarea class="form-control" style="resize: none" readonly>{{ $disposition->dispositionRelation->disposition_message->message }}</textarea>
    @endcomponent
@endsection