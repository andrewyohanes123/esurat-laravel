@extends('layouts.dashboard')

@section('title','Pengguna')

@section('content')
    <div class="card">
      <div class="card-body">
        <h5 class="m-0"><i class="fa fa-users-fa-md"></i>&nbsp;Pengguna</h5>
        <hr>
        {!! $users->links() !!}
        <a href="{{ route('user.create') }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-user-plus fa-lg"></i>&nbsp;Tambah Pengguna</a>
      </div>
      <table class="table table-hover table-striped table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Jabatan</th>
            <th>Edit/Hapus</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($users as $i => $user)
              <tr>
                <td>{{ Request::get('page') ? $i + ((intval(Request::get('page')) - 1)* 10) + 1 : $i +1 }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->department->name }}</td>
                <td>
                  <a href="{{ route('user.show', ['id' => $user->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                  <button class="btn btn-danger btn-sm">Hapus</button>
                </td>
              </tr>
          @endforeach
        </tbody>
      </table>
      <div class="card-body">
        {!! $users->links() !!}
      </div>
    </div>
@endsection
