<?php

namespace App\Http\Controllers;

use App\LetterType;
use Illuminate\Http\Request;

class LetterTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = LetterType::paginate(10);
        return view('pages.letter-types')->withLetterTypes($types);
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
        $this->validate($request, [
            'name' => 'required'
        ], [
            'name.required' => 'Tipe surat harus diisi'
        ]);
        
        $status = LetterType::create($request->all());

        if ($status) {
            return redirect()->route('tipe-surat.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\LetterType  $letterType
     * @return \Illuminate\Http\Response
     */
    public function show(LetterType $letterType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\LetterType  $letterType
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $type = LetterType::find($id);
        return view('pages.letter-type-edit')->withLetterType($type);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\LetterType  $letterType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $status = LetterType::whereId($id)->update([
            'name' => $request->name
        ]);
        
        if ($status) return redirect()->route('tipe-surat.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\LetterType  $letterType
     * @return \Illuminate\Http\Response
     */
    public function destroy(LetterType $letterType)
    {
        //
    }
}
