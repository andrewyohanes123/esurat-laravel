@extends('layouts.dashboard')

@section('title', 'Tambah Pengguna')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Kembali</a></li>
    </ol>
  <div class="card">
    <div class="card-body">
      <h5 class="m-0">Tambah Pengguna</h5>
      <hr>
      <div class="row">
        <div class="col-md-6">
          <form method="post" action="{{ route('user.store') }}" class="form-group">
            <label for="" class="control-label">Nama Lengkap</label>
            <input type="text" placeholder="Nama Lengkap" value="{{ old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror">
            @error('name')
              <label for="" class="invalid-feedback">{{ e($message) }}</label>
            @enderror
            <label for="" class="control-label">Alamat Email</label>
            <input type="email" placeholder="Alamat Email" value="{{ old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror">
            @error('email')
              <label for="" class="invalid-feedback">{{ e($message) }}</label>
            @enderror
            <label for="" class="control-label">Nomor Telepon</label>
            <input type="number" placeholder="Nomor Telepon" value="{{ old('phone_number') }}" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror">
            @error('phone_number')
              <label for="" class="invalid-feedback">{{ e($message) }}</label>
            @enderror
            <label for="" class="control-label">Password</label>
            <input type="password" placeholder="Password" name="password" class="form-control @error('password') is-invalid @enderror">
            @error('password')
              <label for="" class="invalid-feedback">{{ e($message) }}</label>
            @enderror
            <label for="" class="control-label">Jabatan</label>
            <select name="department_id" id="" class="form-control @error('department_id') is-invalid @enderror">
              <option value="">-- Pilih Jabatan --</option>
              @foreach ($departments as $dept)
              <option {{ old('department_id') === $dept->id ? 'selected' : '' }} value="{{ $dept->id }}">{{ $dept->name }}</option>
              @endforeach
            </select>
            @error('department_id')
              <label for="" class="invalid-feedback">{{ e($message) }}</label>
            @enderror
            @csrf
            <hr>
            <button type="submit" class="btn btn-outline-success btn-sm"><i class="fa fa-save fa-md"></i>&nbsp;Tambah</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
