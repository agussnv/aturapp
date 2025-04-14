<?php
    namespace App\Http\Controllers;

    use App\Models\User;
    use App\Models\Blacklist;
    use Illuminate\Support\Str;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Mail;
    use Illuminate\Support\Facades\Validator;

    class UserController extends Controller {
        
        public function index(Request $request) {
            $user = User::with( ['rol:id,name', 'curs:id,name', 'torn:id,torn'])->where('id', $request->alumne_id)->first();
            
            if (!$user) {
                return response()->json(['message' => "Error, no existeix l'usuari"], 400);
            }

            return response()->json($user, 200);
        }

        public function getRol($id) {
            $user = User::with('rol')
                ->where('id', $id)
                ->first();

            if (!$user) {
                return response()->json(['success' => false, 'message' => "L'usuari no existeix"], 400);
            }

            $rolName = $user->rol;
            return response()->json(['success' => true, 'rol' => $rolName], 200);
        }

        public function register(Request $request) {
            $blacklisted = Blacklist::where('email', $request->email)->exists();
            if ($blacklisted) {
                return response()->json([
                    'error' => 'El correu electronic està dintre de la llista negra.',
                ], 400);
            }

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'grade' => 'required|integer|exists:curs,id',
                'dni' => 'required|string|unique:users,dni|max:10',
                'password' => 'required|string|min:6|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 400);
            }

            $user = User::create([
                'nom' => $request->name,
                'cognoms' => $request->surname,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'curs' => $request->grade,
                'rol' => 1,
                'torn' => 1,
                'dni' => $request->dni,
            ]);

            $verificationToken = Str::random(32);
            $user->verification_token = $verificationToken;
            $user->save();

            $verificationUrl = route('verify.email', ['token' => $verificationToken]);

            Mail::raw(
                "Hola {$user->nom} {$user->cognoms},\n\nConfirma el teu usuari fent clic al següent enllaç:\n\n{$verificationUrl}",
                function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject("ATURAPP | Confirma el teu usuari");
                }
            );

            return response()->json([
                'message' => 'Usuari registrat amb èxit. Si us plau, revisa el teu correu per confirmar la teva adreça.',
            ], 201);
        }

        public function verifyEmail($token) {
            $user = User::where('verification_token', $token)->first();

            if (!$user) {
                return response()->json([
                    'error' => 'El token de verificació és invàlid o ha expirat.',
                ], 400);
            }

            $user->email_verified_at = now();
            $user->verification_token = null;
            $user->save();

            return response()->json([
                'message' => 'El correu s\'ha verificat correctament.',
            ], 200);
        }

        public function login(Request $request) {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'message' => 'Credenciales incorrectas',
                ], 401);
            }

            $user = Auth::user();

            if (is_null($user->email_verified_at)) {
                return response()->json(['message' => 'No s\'ha verificat el correu electronic'], 403);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            if ($user->rol == 2) {
                return response()->json([
                    'message' => 'Inicio de sesión exitoso',
                    'user' => [
                        'id' => $user->id,
                        'email' => $user->email,
                        'nom' => $user->nom,
                        'cognom' => $user->cognoms,
                        'dni' => $user->dni,
                        'rol' => $user->rol
                    ],
                    'redirect_to' => '/admin',
                    'token' => $token,
                ]);
            }

            $companys_clase = User::where('curs', $user->curs)->select('nom', 'cognoms', 'id')->get();

            return response()->json([
                'message' => 'Inicio de sesión exitoso',
                'user' => [
                    'id' => $user->id,
                    'email' => $user->email,
                    'nom' => $user->nom,
                    'cognom' => $user->cognoms,
                    'curs' => $user->curs,
                    'dni' => $user->dni,
                    'rol' => $user->rol
                ],
                'course' => [
                    'id' => $user->curs,
                ],
                'companys_clase' => $companys_clase,
                'redirect_to' => '/',
                'token' => $token,
            ]);
        }

        public function updateAlumne(Request $request, $id) {
            $validated = $request->validate([
                'nom' => 'nullable|string|max:255',
                'cognoms' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'dni' => 'nullable|string|max:20',
                'telefon' => 'nullable|string|max:15',
                'curs' => 'nullable|integer|exists:curs,id',
                'torn' => 'nullable|integer|exists:torns,id',
                'rol' => 'nullable|integer|exists:rols,id',
            ]);

            $alumne = User::findOrFail($id);
            $alumne->update($validated);
        
            return response()->json([
                'success' => true,
                'message' => 'Alumno actualizado correctamente.',
            ]);
        }
        
        public function updatePhoto(Request $request) {

            try {
                $validated = $request->validate([
                    'id' => 'required|integer',
                    'imagen' => 'required|file|mimes:jpeg,png,jpg|max:2048',
                ]);
    
                $path = $request->file('imagen')->store('photos', 'custom');
    
                $user = User::findOrFail($request->id);
                $user->foto = $path;
                $user->save();
    
                return response()->json([
                    'success' => true,
                    'path' => asset('photos/' . $path), // Usamos la URL definida en el disco
                ]);
            }  catch (error) {
                console.error("Error efectuado: ", $error);
            }
        }

        public function getPhoto($id) {
            // Busca el usuario en la base de datos
            $user = User::findOrFail($id);

            if (!$user || !$user->foto) {
                return response()->json(['foto' => null], 404);
            }

            // Devuelve la imagen en formato base64
            return response()->json(['foto' => asset('photos/' . $user->foto)]);
        }

        public function getCompanysClase($id){
            $companys = User::where('curs', $id)
                    -> select('id','nom','cognoms')
                    -> get();
            
            if ($companys -> isEmpty()) {
                return response() -> json (['success' => false, 'message' => 'No s\'han trobat els companys'], 404);
            }

            return response() -> json(['success' => true, 'companys' => $companys], 200);
        }

        public function getAlumnes(Request $request) {
            $usuaris = User::with(['curs:id,name', 'torn:id,torn'])
                ->select('id', 'nom', 'cognoms', 'email', 'curs', 'torn','dni','telefon')
                ->get();
        
            return response()->json($usuaris);
        }

        public function getAlumneById($id) {
            $alumne = User::with(['rol:id,name', 'curs:id,name', 'torn:id,torn'])
                ->select('id', 'nom', 'cognoms', 'email', 'curs', 'torn', 'dni', 'telefon', 'rol')
                ->find($id);
        
            if (!$alumne) {
                return response()->json(['success' => false, 'message' => "L'alumne no existeix"], 404);
            }
        
            return response()->json(['success' => true, 'alumne' => $alumne], 200);
        }   

        public function update(Request $request) {
            try {
                $validated = $request->validate([
                    'alumne_id' => 'required|exists:users,id',
                    'nom' => 'required|string|max:255',
                    'cognom' => 'required|string|max:255',
                    'dni' => 'nullable|string|max:20',
                    'telefon' => 'nullable|integer',
                ]);
        
                $user = User::findOrFail($validated['alumne_id']);
        
                $user->nom = $validated['nom'];
                $user->cognoms = $validated['cognom'];
                $user->dni = $validated['dni'];
//              Actualitzar telefon si s'ha modificat, del contrari no es modificara
                if (array_key_exists('telefon', $validated)) {
                    $user->telefon = $validated['telefon'];
                }
                $user->save();
        
                return response()->json([
                    'success' => true,
                    'message' => 'Usuario actualizado con éxito.',
                    'user' => $user,
                ], 200);
        
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el usuario.',
                    'error' => $e->getMessage(),
                ], 500);
            }
        }
    }