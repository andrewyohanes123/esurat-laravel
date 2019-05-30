@extends('layouts.dashboard')

@section('title', 'Tipe Surat')

@section('content')
    <div class="card">
      <div class="card-body">
        <div class="d-flex flex-row justify-content-between align-items-center">
          <a href="{{ route('tipe-surat.index') }}" class="btn d-block btn-outline-dark btn-sm"><i class="fa fa-angle-left fa-lg"></i></a>
          <h5 class="m-0 d-block">Edit &quot;{{ $letterType->name }}&quot;</h5>
        </div>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <form action="{{ route('tipe-surat.update', ['id' => $letterType->id]) }}" method="post" class="form-group">
                <input type="text" placeholder="Tipe Surat" name="name" value="{{ $letterType->name }}" class="form-control">
                @csrf
                @method('PUT')
                <hr>
                <button class="btn btn-outline-success btn-sm"><i class="fa fa-save fa-md"></i>&nbsp;Simpan</button>
            </form>
          </div>
        </div>
      </div>
    </div>
@endsection