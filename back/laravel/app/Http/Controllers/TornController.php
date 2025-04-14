<?php

namespace App\Http\Controllers;

use App\Models\Torn;
use Illuminate\Http\Request;

class TornController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $torn = Torn::select('id', 'torn')->get();
        return response()->json($torn);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Torn $torn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Torn $torn)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Torn $torn)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Torn $torn)
    {
        //
    }
}
