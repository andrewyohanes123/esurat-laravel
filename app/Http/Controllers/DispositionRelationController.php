<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DispositionRelation;
use App\LetterFile;
use App\DispositionMessage;
use App\Setting;
use App\Disposition;

class DispositionRelationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if (Auth::user()->role === 'administrator') {
        //     $dispositions = DispositionRelation::paginate(10)->load(['from_user', 'to_user']);
        // }
        $dispositions = DispositionRelation::paginate(10)->load(['from_user', 'to_user']);
        $setting = Setting::orderBy('id', 'DESC')->get()->first();
        return view('pages.dispositions')->withDispositionRelations($dispositions)->withSetting($setting);
    }

    public function out_disposition()
    {
        $type = 'out';
        $title = 'Disposisi Keluar';
        $icon = 'boxes';
        $dispositions = DispositionRelation::where('from_user', Auth::user()->id)->with(['disposition'])->get()->load(['from_user', 'to_user']);
        $setting = Setting::orderBy('id', 'DESC')->get()->first();
        return view('pages.dispositions', compact('title', 'icon', 'type'))->withDispositionRelations($dispositions)->withSetting($setting);
    }

    public function in_disposition()
    {
        $type = 'in';
        $title = 'Disposisi Masuk';
        $icon = 'inbox';
        $dispositions = DispositionRelation::where('to_user', Auth::user()->id)->get()->load(['from_user', 'to_user']);
        $setting = Setting::orderBy('id', 'DESC')->get()->first();
        return view('pages.dispositions', compact('title', 'icon', 'type'))->withDispositionRelations($dispositions)->withSetting($setting);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = \App\LetterType::all();
        $name = '';
        $recepients = \App\User::whereHas('department', function($q){
            $dept = Auth::user()->department->name;
            if ($dept === 'Jurusan') {
                $name = 'Administrasi';
            } else if ($dept === 'Administrasi') {
                $name = 'Kepala Bagian Umum';
            }
            $q->where('name', '=', $name);
        })->get();
        $setting = \App\Setting::orderBy('id', 'DESC')->get()->first();
        return view('pages.disposition-create')->withLetterTypes($types)->withSetting($setting)->withUsers($recepients);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->hasFile('attachment'));
        $this->validate($request, [
            'purpose' => 'required',
            'content' => 'nullable',
            'description' => 'required',
            'reference_number' => 'required',
            'letter_type_id' => 'required',
            'to_user' => 'required',
            'name' => 'nullable',
            'file' => 'required',
            'file.*' => 'mimes:jpg,png,jpeg,gif,bmp'
        ], [
            'purpose.required' => 'Masukkan tujuan surat',
            'description.required' => 'Masukkan deskripsi surat',
            'to_user.required' => 'Pilih penerima disposisi',
            'letter_type_id.required' => 'Pilih tipe surat',
            'reference_number.required' => 'Masukkan nomor surat',
            'file.required' => 'Masukkan file',
            'file.*.mimes' => 'File surat harus berformat jpg, png atau jpeg'
        ]);

        $id = Auth::user()->id;


        $disposition = Disposition::create([
            'purpose' => $request->purpose,
            'content' => $request->description,
            'description' => $request->description,
            'done' => false,
            'reference_number' => $request->reference_number,
            'letter_type_id' => $request->letter_type_id
        ]);

        $dispositionMessage = DispositionMessage::create([
            'user_id' => $id,
            'message' => $request->description
        ]);

        $status = DispositionRelation::create([
            'from_user' => $id,
            'to_user' => $request->to_user,
            'disposition_id' => $disposition->id,
            'disposition_message_id' => $dispositionMessage->id
        ]);

        if ($request->hasFile('file'))
        {
            foreach($request->file('file') as $file) :
                $filename = $file->getClientOriginalName();
                $name = pathinfo($filename, PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $attachment = $filename . "_" . time() . "." . $ext;
                $file->storeAs('public/attachments', $attachment);
                LetterFile::create([
                    'name' => $name,
                    'file' => $attachment,
                    'disposition_id' => $disposition->id
                ]);
            endforeach;
        }
        return $status ? redirect()->route('disposition.create')->with('success', 'Berhasil mengirim surat') : redirect()->route('disposition.create')->with('failed', 'Gagal mengirim surat');
    }

    public function forward(Request $request, $type, $id)
    {
        $id = Auth::user()->id;
        $dispositionMessage = DispositionMessage::create([
            'user_id' => $id,
            'message' => $request->message
        ]);

        DispositionRelation::create([
            'from_user' => $id,
            'to_user' => $request->to_user,
            'disposition_id' => $request->disposition_id,
            'disposition_message_id' => $dispositionMessage->id
        ]);

        return redirect()->route('disposition.showtype', compact('id', 'type'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $type)
    {
        $recepients = \App\User::whereHas('department', function($q){
            $dept = Auth::user()->department->name;
            if ($dept === 'Jurusan') {
                $name = 'Administrasi';
            } else if ($dept === 'Administrasi') {
                $name = 'Kepala Bagian Umum';
            } else if ($dept === 'Kepala Bagian Umum') {
                $name = 'Direktur';
            } else if ($dept === 'Direktur') {
                $name = 'Sekretaris Pimpinan';
            } else if ($dept === 'Sekretaris Pimpinan') {
                $name = 'Wakil Direktur';
            } else if ($dept === 'Wakil Direktur') {
                $name = 'Jurusan';
            }

            $q->where('name', '=', $name);
        })->get();
        $disposition = Disposition::findOrfail($id);
        $setting = Setting::orderBy('id', 'DESC')->get()->first();
        return view('pages.disposition-show', compact('type'))->withDisposition($disposition)->withSetting($setting)->withUsers($recepients);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
