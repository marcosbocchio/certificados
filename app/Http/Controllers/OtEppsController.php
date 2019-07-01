<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Epps;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection as Collection;

class OtEppsController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ot_epps = DB::select('select 
                            epps.id,
                            epps.descripcion 
                            from epps
                            inner join ot_epps on
                            epps.id = ot_epps.epp_id
                            inner join ots on
                            ot_epps.ot_id = ots.id
                            Where 
                            ots.id =:id',['id' => $id ]);

        $ot_epps = Collection::make($ot_epps);

        return $ot_epps;
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
