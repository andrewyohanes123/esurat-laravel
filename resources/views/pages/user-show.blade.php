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
            <input type="text" placeholder="Nama lengkap" name="name" value="{{ $user->name }}" class="form-control">
            <label for="" class="control-label m-0">Email</label>
            <input type="email" placeholder="Alamat Email" name="email" value="{{ $user->email }}" class="form-control">
            <label for="" class="control-label m-0">Password</label>
            <input type="password" placeholder="Password" name="password"  class="form-control">
            <label for="" class="control-label m-0">Jabatan</label>
            <select name="department_id" id="" class="form-control">
              <option value="">-- Pilih Jabatan --</option>
              @foreach ($departments as $dept)
                  <option {{ $dept->id === $user->department_id ? 'selected' : '' }} value="{{ $dept->id }}">{{ $dept->name }}</option>
              @endforeach
            </select>
            @csrf
            @method('PUT')
            <hr>
            <button class="btn btn-outline-success btn-sm"><i class="fa fa-save fa-md"></i>&nbsp;Simpan</button>
          </form>
        </div>
      </div>
    @endcomponent
@endsection
