<?php

namespace App\Http\Controllers;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class PasswordResetController extends Controller {
    public function sendEmail(Request $request) {
        $email = $request->input('email');
    
        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'Este correo no está registrado.'], 404);
        }
    
        $token = Str::random(60);
    
        Mail::raw(
            "Hola, haz clic en el siguiente enlace para restablecer tu contraseña: " .
            "http://aturapp.daw.inspedralbes.cat/password/reset/{$token}",
            function ($message) use ($email) {
                $message->to($email)
                        ->subject('Restablecer tu contraseña');
            }
        );
    
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => now(),
        ]);
    
        return response()->json(['message' => 'Correo de restablecimiento enviado correctamente.'], 200);
    }
    

    public function showResetForm($token) {
        $reset = DB::table('password_resets')->where('token', $token)->first();

        if (!$reset) {
            return redirect()->route('login')->withErrors(['token' => 'Token inválido o expirado.']);
        }

        return view('auth.passwords.reset', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required|string',
            'password' => 'required|string|confirmed|min:8',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['message' => 'Datos inválidos.', 'errors' => $validator->errors()], 400);
        }
    
        $resetToken = PasswordReset::where('token', $request->token)->first();
    
        if (!$resetToken) {
            return response()->json(['message' => 'Token inválido o expirado.'], 400);
        }
    
        $user = User::where('email', $resetToken->email)->first();
    
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado.'], 400);
        }
    
        $user->password = Hash::make($request->password);
        $user->save();
    
        $resetToken->delete();
    
        return response()->json(['message' => 'Contraseña restablecida con éxito.'], 200);
    }
    
    
    
}