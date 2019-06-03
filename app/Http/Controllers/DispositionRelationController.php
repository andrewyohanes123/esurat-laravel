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

        DispositionRelation::create([
            'from_user' => $id,
            'to_user' => $request->to_user,
            'disposition_id' => $disposition->id,
            'disposition_message_id' => $dispositionMessage->id
        ]);

        // LetterFile::create([
        //     'name' => $request->file_name,
        //     'file' => 
        // ])
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $type)
    {
        $disposition = Disposition::findOrfail($id);
        $setting = Setting::orderBy('id', 'DESC')->get()->first();
        return view('pages.disposition-show', compact('type'))->withDisposition($disposition)->withSetting($setting);
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
