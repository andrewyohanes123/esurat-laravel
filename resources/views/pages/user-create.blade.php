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
            <input type="text" placeholder="Nama Lengkap" name="name" class="form-control">
            <label for="" class="control-label">Alamat Email</label>
            <input type="email" placeholder="Alamat Email" name="email" class="form-control">
            <label for="" class="control-label">Password</label>
            <input type="password" placeholder="Password" name="password" class="form-control">
            <label for="" class="control-label">Jabatan</label>
            <select name="department_id" id="" class="form-control">
              <option value="" selected>-- Pilih Jabatan --</option>
              @foreach ($departments as $dept)
                  <option value="{{ $dept->id }}">{{ $dept->name }}</option>
              @endforeach
            </select>
            @csrf
            <hr>
            <button type="submit" class="btn btn-outline-success btn-sm"><i class="fa fa-save fa-md"></i>&nbsp;Tambah</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
