<?php

namespace App\Http\Controllers;

use App\Disposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DispositionController extends Controller
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

    public function search(Request $req)
    {
        return Disposition::search($req->key)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }


    public function verification($type, $id)
    {
        $status = Disposition::whereId($id)->update(['done' => 1]);
        return $status ? redirect()->route('disposition.showtype', compact('id', 'type')) : '';
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
            'purpose' => 'required',
            'content' => 'nullable',
            'description' => 'required',
            'reference_number' => 'required',
            'letter_type_id' => 'required',
            'send_to' => 'required',
            'name' => 'nullable',
            'file' => 'required',
            'file.*' => 'mimes:jpg,png,jpeg,gif,bmp,pdf'
        ], [
            'purpose.required' => 'Masukkan tujuan surat',
            'description.required' => 'Masukkan deskripsi surat',
            'send_to.required' => 'Pilih penerima disposisi',
            'letter_type_id.required' => 'Pilih tipe surat',
            'reference_number.required' => 'Masukkan nomor surat',
            'file.required' => 'Masukkan file',
            'file.*.mimes' => 'File surat harus berformat PDF, jpg, png atau jpeg'
        ]);

        $id = Auth::user()->id;

        $disposition = Disposition::create([
            'reference_number' => $request->reference_number,
            'purpose' => $request->purpose,
            'content' => $request->description,
            'description' => $request->description,
            'letter_type_id' => $request->letter_type_id,
            'send_to' => $request->send_to,
            'letter_sort' => 'Surat Keluar',
            'from_user' => $id,
            'last_user' => $id
        ]);

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) :
                $filename = $file->getClientOriginalName();
                $name = pathinfo($filename, PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $attachment = $filename . "_" . time() . "." . $ext;
                $file->storeAs('public/attachments', $attachment);
                \App\LetterFile::create([
                    'name' => $name,
                    'file' => $attachment,
                    'type' => $file->getClientMimeType(),
                    'disposition_id' => $disposition->id
                ]);
            endforeach;
        }

        return $disposition ? redirect()->route('outletter.create')->with('success', 'Berhasil menyimpan surat keluar') : redirect()->route('outletter.create')->with('failed', 'Gagal mengirim surat');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Disposition  $disposition
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $disposition = Disposition::findOrFail($id);
        $setting = \App\Setting::orderBy('id', 'DESC')->get()->first();
        // return compact('disposition', 'setting');
        return view('pages.outletter-show')->withDisposition($disposition)->withSetting($setting);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Disposition  $disposition
     * @return \Illuminate\Http\Response
     */
    public function edit(Disposition $disposition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Disposition  $disposition
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disposition $disposition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Disposition  $disposition
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disposition $disposition)
    {
        //
    }
}
