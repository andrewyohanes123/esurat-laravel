<?php

namespace App\Http\Controllers;

use App\LetterFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LetterFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->id);
        $request->validate([
            'file' => 'required',
            'file.*' => 'mimes:jpg,png,jpeg,gif,bmp,pdf',
        ], [
            'file.required' => 'Masukkan file',
            'file.*.mimes' => 'File surat harus berformat PDF, jpg, png atau jpeg'
        ]);

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) :
                $filename = $file->getClientOriginalName();
                $name = pathinfo($filename, PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $attachment = $name . "_" . time() . "." . $ext;
                LetterFile::create([
                    'name' => $name,
                    'file' => $attachment,
                    'type' => $file->getClientMimeType(),
                    'disposition_id' => intval($request->id)
                ]);
                $file->storeAs('public/attachments', $attachment);
            endforeach;
        }
        return redirect()->route('disposition.edit', ['id' => $request->disposition]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LetterFile  $letterFile
     * @return \Illuminate\Http\Response
     */
    public function show(LetterFile $letterFile)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LetterFile  $letterFile
     * @return \Illuminate\Http\Response
     */
    public function edit(LetterFile $letterFile)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LetterFile  $letterFile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, LetterFile $letterFile)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LetterFile  $letterFile
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $req)
    {
        $file = LetterFile::findOrFail($id)->file;
        $res = Storage::delete("public/attachments/{$file}");
        $file = LetterFile::destroy($id);
        return $file ? redirect()->route('disposition.edit', ['id' => $req->disposition])  : '';
    }
}
