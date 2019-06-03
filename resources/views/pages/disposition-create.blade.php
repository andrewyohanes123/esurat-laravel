@extends('layouts.dashboard')

@section('title', 'Buat Surat | ' . Auth::user()->name)

@section('content')
    @component('components.card')
        @slot('title')
            <i class="fa fa-envelope-open fa-lg"></i>&nbsp;Buat Surat
        @endslot
        <form action="{{ route('disposition.store') }}" method="POST" class="form-group">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <label for="" class="control-label my-2">Nomor Surat</label>
                    <input type="text" placeholder="Nomor Surat" class="form-control" name="reference_number">
                    <label for="" class="control-label my-2">Tujuan</label>
                    <input type="text" placeholder="Tujuan Surat" name="purpose" class="form-control">
                    <label for="" class="control-label my-2">Tipe Surat</label>
                    <select name="letter_type_id" id="" class="form-control">
                        <option value="" selected>-- Pilih Tipe Surat --</option>
                        @foreach ($letterTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                    <label for="" class="control-label my-2">Deskripsi</label>
                    <textarea name="description" rows="5" style="resize: none" placeholder="Deskripsi Surat" class="form-control"></textarea>
                </div>
                <div class="col-md-6">
                    <label for="" class="control-label my-2">Dikirim Ke</label>
                    <select name="to_user" id="" class="form-control">
                        <option value="" selected>-- Pilih Penerima Surat --</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->department->name }}</option>
                        @endforeach
                    </select>
                    <label for="" class="control-label my-2">Nama File</label>
                    <input type="text" name="file_name" placeholder="Nama File" class="form-control">
                    <label for="" class="control-label my-2">File Surat</label>
                    <input type="file" class="form-control" name="file" id="">
                    <hr>
                    <button type="submit" class="btn btn-outline-success btn-sm">Kirim</button>
                </div>
            </div>
        </form>
    @endcomponent
@endsection