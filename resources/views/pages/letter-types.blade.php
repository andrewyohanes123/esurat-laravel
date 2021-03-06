@extends('layouts.dashboard')

@section('title', 'Tipe Surat')

@section('content')
    <div class="card">
      <div class="card-body">
        <h5 class="m-0">Tipe Surat</h5>
        <hr>
        <div class="row">
          <div class="col-md-6">
            <form class="form-group" action="{{ route('tipe-surat.store') }}" method="post">
              <input type="text" placeholder="Tipe (Contoh : Penting, Sangat Penting)" name="name" id="" class="form-control @error('name') is-invalid @enderror">
              @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
              @enderror
              <hr>
              <button type="submit" class="btn btn-outline-success btn-sm">Tambah</button>
              @csrf
            </form>
          </div>
          <div class="col-md-6">
            {{ $letterTypes->links() }}
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th>Tipe</th>
                  <th>Edit/Hapus</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($letterTypes as $type)
                    <tr>
                      <td>{{ $type->name }}</td>
                      <td>
                        <a href="{{ route('tipe-surat.edit', $type) }}" class="btn btn-warning btn-sm">Edit</a>
                        @php
                            $id = $type->id;
                        @endphp
                        <form action="{{ route('tipe-surat.destroy', compact('id')) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                      </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection