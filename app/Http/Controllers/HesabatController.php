<?php

namespace App\Http\Controllers;

use App\Hesabat;
use Illuminate\Http\Request;

class HesabatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Hesabat::all();
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
        $res= new Hesabat();
        $res->hesab_ad = $request->hesab_ad;
        $res->html = $request->html;
        $res->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hesabat  $hesabat
     * @return \Illuminate\Http\Response
     */
    public function show(Hesabat $hesabat)
    {
        return Hesabat::find($hesabat['id']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hesabat  $hesabat
     * @return \Illuminate\Http\Response
     */
    public function edit(Hesabat $hesabat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hesabat  $hesabat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hesabat $hesabat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hesabat  $hesabat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hesabat $hesabat)
    {
       $hesabat->delete();
    }
}
