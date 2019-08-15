<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DispositionRelation;
use App\LetterFile;
use App\DispositionMessage;
use App\Setting;
use App\Disposition;
use App\Notifications\ForwardDisposition;
use App\Notifications\NewDisposition;
use Telegram\Bot\Laravel\Facades\Telegram;

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

    public function out_disposition(Request $req)
    {
        $type = 'out';
        $title = 'Disposisi Keluar';
        $icon = 'boxes';
        if ($req->key) {
            $key = $req->key;
            $dispositions = DispositionRelation::where('from_user', Auth::user()->id)
                ->with(['disposition'])->whereHas('disposition', function ($q) use ($key) {
                    $q->where('reference_number', 'like', "%{$key}%");
                    $q->orWhere('purpose', 'like', "%{$key}%");
                    $q->orWhere('description', 'like', "%{$key}%");
                    $q->where('letter_sort', 'Surat Masuk');
                })->get()->load(['from_user', 'to_user']);
        } else {
            $dispositions = DispositionRelation::where('from_user', Auth::user()->id)->with(['disposition'])->whereHas('disposition', function ($q) {
                $q->where('letter_sort', 'Surat Masuk');
            })->get()->load(['from_user', 'to_user']);
        }
        $setting = Setting::orderBy('id', 'DESC')->get()->first();
        return view('pages.dispositions', compact('title', 'icon', 'type'))->withDispositionRelations($dispositions)->withSetting($setting);
    }

    public function in_disposition(Request $req)
    {
        $type = 'in';
        $title = 'Disposisi Masuk';
        $icon = 'inbox';
        if ($req->key) {
            $key = $req->key;
            $dispositions = DispositionRelation::where('to_user', Auth::user()->id)
                ->with(['disposition'])->whereHas('disposition', function ($q) use ($key) {
                    $q->where('reference_number', 'like', "%{$key}%");
                    $q->orWhere('purpose', 'like', "%{$key}%");
                    $q->orWhere('description', 'like', "%{$key}%");
                    $q->where('letter_sort', 'Surat Masuk');
                })->get()->load(['from_user', 'to_user']);
        } else {
            $dispositions = DispositionRelation::where('to_user', Auth::user()->id)->with(['disposition'])->whereHas('disposition', function ($q) {
                $q->where('letter_sort', 'Surat Masuk');
            })->get()->load(['from_user', 'to_user']);
        }
        $setting = Setting::orderBy('id', 'DESC')->get()->first();
        return view('pages.dispositions', compact('title', 'icon', 'type'))->withDispositionRelations($dispositions)->withSetting($setting);
    }

    public function outletter(Request $request)
    {
        $type = 'in';
        $title = 'Surat Keluar';
        $icon = 'inbox';
        if ($request->key) {
            $dispositions = Disposition::where('letter_sort', 'Surat Keluar')
            ->where('purpose', 'like', "%{$request->key}%")
            ->orWhere('reference_number', 'like', "%{$request->key}%")
            ->orWhere('description', 'like', "%{$request->key}%")
            ->paginate(10);
        } else {
            $dispositions = Disposition::where('letter_sort', 'Surat Keluar')->paginate(10);
        }
        $setting = Setting::orderBy('id', 'DESC')->get()->first();
        return view('pages.outletters', compact('title', 'icon', 'type'))->withSetting($setting)->withDispositions($dispositions);
    }

    public function outletter_create()
    {
        $types = \App\LetterType::all();
        $setting = \App\Setting::orderBy('id', 'DESC')->get()->first();
        $recepients = \App\User::whereHas('department', function ($q) {
            $q->where('name', '=', 'Administrasi');
        })->get();
        return view('pages.outletter-create')->withLetterTypes($types)->withSetting($setting)->withUsers($recepients);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = \App\LetterType::all();
        $recepients = \App\User::whereHas('department', function ($q) {
            $name = '';
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
    public function outletter_store(Request $request)
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
            'file.*' => 'mimes:jpg,png,jpeg,gif,bmp,pdf'
        ], [
            'purpose.required' => 'Masukkan tujuan surat',
            'description.required' => 'Masukkan deskripsi surat',
            'to_user.required' => 'Pilih penerima disposisi',
            'letter_type_id.required' => 'Pilih tipe surat',
            'reference_number.required' => 'Masukkan nomor surat',
            'file.required' => 'Masukkan file',
            'file.*.mimes' => 'File surat harus berformat PDF, jpg, png atau jpeg'
        ]);

        $id = Auth::user()->id;


        $disposition = Disposition::create([
            'purpose' => $request->purpose,
            'content' => $request->description,
            'description' => $request->description,
            'done' => false,
            'reference_number' => $request->reference_number,
            'letter_type_id' => $request->letter_type_id,
            'letter_sort' => 'Surat Keluar'
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

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) :
                $filename = $file->getClientOriginalName();
                $name = pathinfo($filename, PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $type = $file->getMimeType();
                $attachment = $filename . "_" . time() . "." . $ext;
                $file->storeAs('public/attachments', $attachment);
                LetterFile::create([
                    'name' => $name,
                    'file' => $attachment,
                    'type' => $type,
                    'disposition_id' => $disposition->id
                ]);
            endforeach;
        }
        return $status ? redirect()->route('disposition.create')->with('success', 'Berhasil mengirim surat') : redirect()->route('disposition.create')->with('failed', 'Gagal mengirim surat');
    }
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
            'file.*' => 'mimes:jpg,png,jpeg,gif,bmp,pdf'
        ], [
            'purpose.required' => 'Masukkan tujuan surat',
            'description.required' => 'Masukkan deskripsi surat',
            'to_user.required' => 'Pilih penerima disposisi',
            'letter_type_id.required' => 'Pilih tipe surat',
            'reference_number.required' => 'Masukkan nomor surat',
            'file.required' => 'Masukkan file',
            'file.*.mimes' => 'File surat harus berformat PDF, jpg, png atau jpeg'
        ]);

        $id = Auth::user()->id;

        $disposition = Disposition::create([
            'purpose' => $request->purpose,
            'content' => $request->description,
            'description' => $request->description,
            'done' => false,
            'reference_number' => $request->reference_number,
            'letter_type_id' => $request->letter_type_id,
            'from_user' => $id,
            'last_user' => $request->to_user
        ]);

        $notify_user = \App\User::findOrFail($request->to_user);
        $notify_user->notify(new NewDisposition(Auth::user(), $notify_user, $disposition));

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

        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) :
                $filename = $file->getClientOriginalName();
                $name = pathinfo($filename, PATHINFO_FILENAME);
                $ext = $file->getClientOriginalExtension();
                $attachment = $filename . "_" . time() . "." . $ext;
                $file->storeAs('public/attachments', $attachment);
                LetterFile::create([
                    'name' => $name,
                    'file' => $attachment,
                    'type' => $file->getClientMimeType(),
                    'disposition_id' => $disposition->id
                ]);
            endforeach;
        }
        return $status ? redirect()->route('disposition.create')->with('success', 'Berhasil mengirim surat') : redirect()->route('disposition.create')->with('failed', 'Gagal mengirim surat');
    }

    public function forward(Request $request, $type, $id)
    {
        // dd($request->to_user);
        $this->validate($request, [
            'message' => 'required|min:10',
            'to_user' => 'required'
        ], [
            'message.required' => 'Masukkan pesan disposisi',
            'message.min' => 'Pesan disposisi minimal 10 karakter',
            'to_user.required' => 'Pilih penerima disposisi'
        ]);

        $idUser = Auth::user()->id;

        $d = Disposition::whereId($request->disposition_id)->get()->first();
        
        $status = $d->update([
            'last_user' => $request->to_user[0]
        ]);

        $dispositionMessage = DispositionMessage::create([
            'user_id' => $id,
            'message' => $request->message
        ]);

        
        foreach($request->to_user as $user) {
            $from_user = \App\User::findOrFail($d->from_user);
            $notify_user = \App\User::findOrFail($user);

            $notify_user->notify(new ForwardDisposition(Auth::user(), $notify_user, $d));
            Telegram::sendMessage([
                'chat_id' => -1001198039198,
                'parse_mode' => 'HTML',
                'text' => "Disposisi {$d->reference_number} di-forward ke {$notify_user->name}"
            ]);

            if (Auth::user()->id !== $from_user->id) {
                $from_user->notify(new ForwardDisposition(Auth::user(), $notify_user, $d));
            }

            DispositionRelation::create([
                'from_user' => $idUser,
                'to_user' => $user,
                'disposition_id' => $request->disposition_id,
                'disposition_message_id' => $dispositionMessage->id
            ]);
        }

        // return $id;
        return $status ? redirect()->route('disposition.showtype', compact('id', 'type'))->with('success', 'Berhasil didisposisi') : '';
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $type)
    {
        $recepients = \App\User::whereHas('department', function ($q) {
            $dept = Auth::user()->department->name;
            $or = '';
            if ($dept === 'Jurusan') {
                $name = 'Administrasi';
            } else if ($dept === 'Administrasi') {
                $name = 'Kepala Bagian Umum';
            } else if ($dept === 'Kepala Bagian Umum') {
                $name = 'Direktur';
                $or = 'Kepala Sub Bagian Umum';
            } else if ($dept === 'Direktur') {
                $name = 'Sekretaris Pimpinan';
            } else if ($dept === 'Sekretaris Pimpinan') {
                $name = 'Wakil Direktur%';
            } else if ($dept === 'Wakil Direktur 1' || $dept === 'Wakil Direktur 2' || $dept === 'Wakil Direktur 3') {
                $name = 'Kepala Bagian Umum';
            }

            $q->where('name', 'LIKE', $name)->orWhere('name', 'LIKE', $or);
        })->get();
        $disposition = DispositionRelation::with(['disposition.lastUser'])->findOrfail($id)->load(['from_user', 'to_user']);
        $setting = Setting::orderBy('id', 'DESC')->get()->first();
        return view('pages.disposition-show', compact('type'))->withDispositionRelation($disposition)->withSetting($setting)->withUsers($recepients);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $disposition = DispositionRelation::with(['disposition.lastUser'])->findOrfail($id)->load(['from_user', 'to_user']);
        $setting = Setting::orderBy('id', 'DESC')->get()->first();
        $types = \App\LetterType::all();
        return view('pages.disposition-edit')->withDispositionRelation($disposition)->withSetting($setting)->withLetterTypes($types);
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
        $this->validate($request, [
            'purpose' => 'required',
            'content' => 'nullable',
            'description' => 'required',
            'reference_number' => 'required',
            'letter_type_id' => 'required',
        ], [
            'purpose.required' => 'Masukkan tujuan surat',
            'description.required' => 'Masukkan deskripsi surat',
            'to_user.required' => 'Pilih penerima disposisi',
            'letter_type_id.required' => 'Pilih tipe surat',
            'reference_number.required' => 'Masukkan nomor surat',
        ]);

        $disposition = Disposition::where('id', $id)->update([
            'purpose' => $request->purpose,
            'content' => $request->description,
            'reference_number' => $request->reference_number,
            'letter_type_id' => $request->letter_type_id,
            'description' => $request->description
        ]);

        return $disposition ? redirect()->route('disposition.edit', ['id' => $request->disposition]) : $request->all();
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
