<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\DispositionRelation;
use App\Setting;

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
        $status = Disposition::create([
            'purpose' => $request->purpose,
            'content' => $request->content,
            'description' => $request->description,
            'done' => false,
            'reference_number' => $request->reference_number,
            'letter_type_id' => $request->letter_type_id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
