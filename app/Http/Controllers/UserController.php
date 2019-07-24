<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Department;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('pages.users')->withUsers($users);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depts = Department::all();
        return view('pages.user-create')->withDepartments($depts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|unique:users|email',
            'password' => 'required',
            'department_id' => 'required',
            'phone_number' => 'required'
        ], [
            'name.required' => 'Masukkan nama pengguna',
            'email.required' => 'Masukkan alamat email',
            'email.unique' => 'Alamat email telah dipakai oleh pengguna lain',
            'email.email' => 'Masukkan alamat email yang valid',
            'password.required' => 'Masukkan password',
            'department_id.required' => 'Pilih jabatan',
            'phone_number.required' => 'Masukkan nomor telepon'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'employee',
            'department_id' => $request->department_id,
            'phone_number' => $request->phone_number
        ]);

        if ($user) return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $depts = \App\Department::all();
        return view('pages.user-show')->withUser($user)->withDepartments($depts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = Auth::user();
        $departments = Department::all();
        return view('pages.user-edit')->withUser($user)->withDepartments($departments);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable',
            'department_id' => 'required',
            'phone_number' => 'required'
        ], [
            'name.required' => 'Masukkan nama pengguna',
            'email.required' => 'Masukkan alamat email',
            // 'email.unique' => 'Alamat email telah dipakai oleh pengguna lain',
            'department_id.required' => 'Pilih jabatan',
            'phone_number.required' => 'Masukkan nomor telepon'
        ]);

        if ($request->has('password')) {
            $user = User::whereId($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'department_id' => $request->department_id,
                'phone_number' => $request->phone_number
            ]);
        } else {
            $user = User::whereId($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'department_id' => $request->department_id,
                'phone_number' => $request->phone_number
            ]);
        }

        return $user ? redirect()->route('user.show', compact('id'))->with('success', 'Sukses mengedit user') 
        : 
        redirect()->route('user.show', compact('id'))->with('error', 'Gagal mengedit user');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $state = User::destroy($id);
        return $state ? redirect()->route('user.index') : redirect()->route('user.index')->with(['error' => 'Gagal menghapus pengguna']);
    }
}
