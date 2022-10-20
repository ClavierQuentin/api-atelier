<?php

namespace App\Http\Controllers;

use App\Models\ListEmail;
use App\Http\Requests\StoreListEmailRequest;
use App\Http\Requests\UpdateListEmailRequest;

class ListEmailController extends Controller
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
     * @param  \App\Http\Requests\StoreListEmailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreListEmailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ListEmail  $listEmail
     * @return \Illuminate\Http\Response
     */
    public function show(ListEmail $listEmail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ListEmail  $listEmail
     * @return \Illuminate\Http\Response
     */
    public function edit(ListEmail $listEmail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateListEmailRequest  $request
     * @param  \App\Models\ListEmail  $listEmail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateListEmailRequest $request, ListEmail $listEmail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ListEmail  $listEmail
     * @return \Illuminate\Http\Response
     */
    public function destroy(ListEmail $listEmail)
    {
        //
    }
}
