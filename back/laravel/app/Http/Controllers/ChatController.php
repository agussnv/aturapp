<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chats = Chat::with(['users.curs', 'users.torn'])
        ->orderByDesc('created_at')
        ->get()
        ->map(function ($chat) {
            return [
                'id' => $chat->id,
                'alumne_id' => $chat->users->id,
                'alumne_nom' => $chat->users->nom,
                'alumne_cognom' => $chat->users->cognoms,
                'alumne_email' => $chat->users->email,
                // 'alumne_foto' => $chat->users->foto,
                'alumne_curs' => $chat->users->curs,
                'alumne_torn' => $chat->users->torn,
                'fecha' => $chat->created_at,
            ];
        });

        return response()->json($chats);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validated = $request->validate([
            "alumno_id"=> "required|integer",
        ]);

        $chat_id = Chat::create([
            "alumno_id" => $validated["alumno_id"],
        ]);

        return response()->json($chat_id);
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
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chat $chat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chat $chat)
    {
        //
    }
}
