@extends('layouts.dashboard')

@section('title', 'Buat Surat | ' . Auth::user()->name)

@section('content')
    @component('components.card')
        @slot('title')
            <i class="fa fa-envelope-open fa-lg"></i>&nbsp;Buat Surat
        @endslot
        <form action="{{ route('disposition.store') }}" method="POST" enctype="multipart/form-data" class="form-group">
            @csrf
            {{-- @if(session('success'))
            <div class="alert alert-success">{{ $message }}</div>
            @elseif(session('failed'))
            <div class="alert alert-danger">{{ $message }}</div>
            @endif --}}
            <div class="row">
                <div class="col-md-6">
                    <label for="" class="control-label my-2">Nomor Surat</label>
                    <input type="text" placeholder="Nomor Surat" class="form-control @error('reference_number') is-invalid @enderror" value="{{ old('reference_number') }}" name="reference_number">
                    @error('reference_number')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                    <label for="" class="control-label my-2">Tujuan</label>
                    <input type="text" placeholder="Tujuan Surat" name="purpose" value="{{ old('purpose') }}" class="form-control @error('purpose') is-invalid @enderror">
                    @error('purpose')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                    <label for="" class="control-label my-2">Tipe Surat</label>
                    <select name="letter_type_id" id="" class="form-control @error('letter_type_id') is-invalid @enderror">
                        <option value="">-- Pilih Tipe Surat --</option>
                        @foreach ($letterTypes as $type)
                        <option {{ old('letter_type_id') === $type->id ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    @error('letter_type_id')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                    <label for="" class="control-label my-2">Deskripsi</label>
                    <textarea name="description" rows="5" style="resize: none" placeholder="Deskripsi Surat" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="" class="control-label my-2">Dikirim Ke</label>
                    <select name="to_user" id="" class="form-control @error('to_user') is-invalid @enderror">
                        <option value="">-- Pilih Penerima Surat --</option>
                        @foreach ($users as $user)
                        <option {{ old('to_user') === $type->id ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }} - {{ $user->department->name }}</option>
                        @endforeach
                    </select>
                    @error('to_user')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                    {{-- <label for="" class="control-label my-2">Nama File</label>
                    <input type="text" name="file_name" placeholder="Nama File" class="form-control"> --}}
                    <label for="" class="control-label my-2">File Surat</label>
                    <input type="file" class="form-control @error('file.*') is-invalid @enderror" name="file[]" multiple id="">
                    @error('file.*')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                    <hr>
                    <button type="submit" class="btn btn-outline-success btn-sm">Kirim</button>
                </div>
            </div>
        </form>
    @endcomponent
@endsection
