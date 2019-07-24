@extends('layouts.dashboard')

@section('title', 'Pengaturan | ' . $user->name)

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Kembali</a></li>
    </ol>
    @component('components.card')
      @slot('title', $user->name)
      <div class="row">
        <div class="col-md-6">
          <form action="{{ route('user.update', ['id' => $user->id]) }}" method="post">
            <label for="" class="control-label m-0">Nama lengkap</label>
            <input type="text" placeholder="Nama lengkap" name="name" value="{{ $errors->first('name') ? old('name') : $user->name }}" class="form-control @error('name') is-invalid @enderror">
            @error('name')
              <label for="" class="invalid-feedback">{{ e($message) }}</label>
            @enderror
            <label for="" class="control-label m-0">Email</label>
            <input type="email" placeholder="Alamat Email" name="email" value="{{ $errors->first('email') ? old('email') : $user->email }}" class="form-control @error('email') is-invalid @enderror">
            @error('email')
              <label for="" class="invalid-feedback">{{ e($message) }}</label>
            @enderror
            <label for="" class="control-label m-0">Nomor Telepon</label>
            <input type="number" placeholder="Nomor Telepon" name="phone_number" value="{{ $errors->first('phone_number') ? old('phone_number') : $user->phone_number }}" class="form-control @error('phone_number') is-invalid @enderror">
            @error('phone_number')
              <label for="" class="invalid-feedback">{{ e($message) }}</label>
            @enderror
            <label for="" class="control-label m-0">Password</label>
            <input type="password" placeholder="Password" name="password"  class="form-control @error('password') is-invalid @enderror">
            @error('password')
              <label for="" class="invalid-feedback">{{ e($message) }}</label>
            @enderror
            <label for="" class="control-label m-0">Jabatan</label>
            <select name="department_id" id="" class="form-control @error('department_id') is-invalid @enderror">
              <option value="">-- Pilih Jabatan --</option>
              @foreach ($departments as $dept)
              <option {{ $errors->first('email') ? old('email') === $user->department_id ? 'selected' : '' : $dept->id === $user->department_id ? 'selected' : '' }} value="{{ $dept->id }}">{{ $dept->name }}</option>
              @endforeach
            </select>
            @error('department_id')
              <label for="" class="invalid-feedback">{{ e($message) }}</label>
            @enderror
            @csrf
            @method('PUT')
            <hr>
            <button class="btn btn-outline-success btn-sm"><i class="fa fa-save fa-md"></i>&nbsp;Simpan</button>
          </form>
        </div>
      </div>
    @endcomponent
@endsection
