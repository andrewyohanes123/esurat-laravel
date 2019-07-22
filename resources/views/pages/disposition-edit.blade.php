@extends('layouts.dashboard')

@section('title', 'Edit surat | ' . Auth::user()->name)

@section('content')
    @component('components.card')
        @slot('title')
            <i class="fa fa-edit fa-lg"></i>&nbsp;Edit {{ $dispositionRelation->disposition->reference_number }}
        @endslot
        {{-- <form action="{{ route('disposition.store') }}" method="POST" enctype="multipart/form-data" class="form-group"> --}}
            @csrf
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('failed'))
            <div class="alert alert-danger">{{ session('failed') }}</div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <label for="" class="control-label my-2">Nomor Surat</label>
                    <input type="text" placeholder="Nomor Surat" class="form-control @error('reference_number') is-invalid @enderror" value="{{ $errors->first('reference_number') ? old('reference_number') : $dispositionRelation->disposition->reference_number }}" name="reference_number">
                    @error('reference_number')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                    <label for="" class="control-label my-2">Tujuan</label>
                    <input type="text" placeholder="Tujuan Surat" name="purpose" value="{{ $errors->first('purpose') ? old('purpose') : $dispositionRelation->disposition->purpose }}" class="form-control @error('purpose') is-invalid @enderror">
                    @error('purpose')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                    <label for="" class="control-label my-2">Tipe Surat</label>
                    @if (sizeof($letterTypes) > 0)
                        <select name="letter_type_id" id="" class="form-control @error('letter_type_id') is-invalid @enderror">
                            <option value="">-- Pilih Tipe Surat --</option>
                            @foreach ($letterTypes as $type)
                            <option {{ old('letter_type_id') === $type->id ? 'selected' : '' || $dispositionRelation->disposition->letter_type_id === $type->id ? 'selected' : '' }} value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    @else
                        <input type="text" name="" disabled class="form-control" placeholder="Tidak ada tipe surat. Hubungi Super Admin" id="">
                    @endif
                    @error('letter_type_id')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                    <label for="" class="control-label my-2">Deskripsi</label>
                    <textarea name="description" rows="5" style="resize: none" placeholder="Deskripsi Surat" class="form-control @error('description') is-invalid @enderror">{{ $errors->first('description') ? old('description') : $dispositionRelation->disposition->description }}</textarea>
                    @error('description')
                        <span class="invalid-feedback"><strong>{{ $message }}</strong></span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <h5 class="my-1">Tambah file</h5>
                    <form action="{{ route('files.store') }}" enctype="multipart/form-data" method="POST" class="form-group">
                        @csrf
                        <input type="hidden" name="id" value="{{ $dispositionRelation->disposition->id }}">
                        <input type="hidden" name="disposition" value="{{ $dispositionRelation->id }}">
                        <input type="file" name="file[]" multiple id="" class="form-control my-2">
                        @error('file')
                            {{ $error }}
                        @enderror
                        <button class="btn btn-success btn-sm">Tambah</button>
                    </form>
                    <hr>
                    <div class="card-columns">
                        @php 
                            $files = $dispositionRelation->disposition->letterFiles()->get() 
                        @endphp
                        @foreach ( $files as $file)
                            {{-- <div class="col-sm-6 col-md-6 my-2"> --}}
                                <div class="card">
                                    @if ($file->type !== 'application/pdf')
                                        <img src="{{ Storage::url('attachments/' . $file->file) }}" alt="" class="card-img-top">
                                    @endif
                                    <div class="card-body">
                                        {{ Str::limit($file->name, 10) }}
                                        <form action="{{ route('files.destroy', ['id' => $file->id]) }}" method="POST" class="inline-form">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="disposition" value="{{ $dispositionRelation->id }}">
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash fa-md"></i></button>
                                        </form>
                                    </div>
                                </div>
                            {{-- </div> --}}
                        @endforeach
                    </div>                    
                </div>
            </div>
        {{-- </form> --}}
    @endcomponent
@endsection
