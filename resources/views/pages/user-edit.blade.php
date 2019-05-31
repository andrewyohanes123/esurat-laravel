@extends('layouts.dashboard')

@section('title', 'Pengaturan | ' . $user->name)

@section('content')
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
            <select name="" id="" class="form-control" disabled="disabled">
              <option value="">{{ $user->department->name }}</option>
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