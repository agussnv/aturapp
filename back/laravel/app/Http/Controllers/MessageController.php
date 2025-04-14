<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'emisor' => 'sometimes|nullable|integer',
            'texto' => 'required|string',
            'chat_id' => 'required|integer',
            'id_message' => 'required|string',
            'editado' => 'sometimes|nullable|boolean'
        ]);

        try {
            $message = Message::create([
                'emisor' => $request->emisor,
                'texto' => $request->texto,
                'chat_id' => $request->chat_id,
                'id_message' => $request->id_message,
                'editado' => $request->editado,
            ]);

            return response()->json(['message' => 'Mensaje creado exitosamente', 'data' => $message], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al crear el mensaje', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $validated = $request->validate([
            'chat_id' => 'required|integer',
            'rol_id' => 'required|integer'
        ]);

        if ($validated['rol_id'] === 2) {
            $messages = Message::where('chat_id', $validated['chat_id'])->get();

            return response()->json($messages);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'id_message' => 'required|string',
                'alumno_id' => 'required|integer',
                'textEdit' => 'required|string',
            ]);
    
            $message = Message::where('id_message',$validated['id_message'])->first();
    
            if ($validated['alumno_id'] === $message->emisor) {
                $message->texto = $validated['textEdit'];
                $message->update();
    
                return response()->json(['message' => 'Mensaje editado exitosamente', 'data' => $message], 201);
            }
            return response()->json(['error' => 'Unauthorized'], 403);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocurrió un error al editar el mensaje', 'details' => $e->getMessage()], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
