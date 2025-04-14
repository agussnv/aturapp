<?php
    namespace App\Http\Controllers;

    use App\Models\User;
    use App\Models\Pregunta;
    use App\Models\Respostas;
    use Illuminate\Http\Request;

    class RespostasController extends Controller {
        public function index() {
        }

        public function create() {
        }

        public function store(Request $request) {
            try {
                $validated = $request->validate([
                    'respuestas' => 'required|array',
                    'respuestas.*.id_pregunta' => 'required|integer|exists:preguntas,id',
                    'respuestas.*.resposta1' => 'required|integer|exists:users,id',
                    'respuestas.*.resposta2' => 'required|integer|exists:users,id',
                    'respuestas.*.resposta3' => 'required|integer|exists:users,id',
                    'respuestas.*.id_alumno_emisor' => 'required|integer|exists:users,id',
                    'respuestas.*.id_curs_alumno_emisor' => 'required|integer|exists:curs,id',
                ]);
        
                foreach ($validated['respuestas'] as $respuesta) {
                    Respostas::create([
                        'id_pregunta' => $respuesta['id_pregunta'],
                        'resposta1' => $respuesta['resposta1'],
                        'resposta2' => $respuesta['resposta2'],
                        'resposta3' => $respuesta['resposta3'],
                        'id_alumno_emisor' => $respuesta['id_alumno_emisor'],
                        'id_curs_alumno_emisor' => $respuesta['id_curs_alumno_emisor'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
        
                return response()->json(['message' => 'Respuestas guardadas exitosamente.'], 200);
            } catch (Exception $e) {
                return response()->json(['error' => 'Ocurrió un error al guardar las respuestas.', 'details' => $e->getMessage()], 500);
            }
        }
        
        
        
        public function get(Request $request) {
            $respostas = Respostas::with(['pregunta', 'userResposta1', 'userResposta2', 'userResposta3', 'curso'])->get();
        
            $respostasTransformadas = $respostas->map(function ($resposta) {
                return [
                    'pregunta' => [
                        'id' => $resposta->id_pregunta,
                        'relacion' => $resposta->pregunta ? $resposta->pregunta->pregunta : null,
                    ],
                    'resposta 1' => [
                        'id' => $resposta->resposta1,
                        'relacion' => $resposta->userResposta1 ? $resposta->userResposta1->nom . ' ' . $resposta->userResposta1->cognoms : null,
                    ],
                    'resposta 2' => [
                        'id' => $resposta->resposta2,
                        'relacion' => $resposta->userResposta2 ? $resposta->userResposta2->nom . ' ' . $resposta->userResposta2->cognoms : null,
                    ],
                    'resposta 3' => [
                        'id' => $resposta->resposta3,
                        'relacion' => $resposta->userResposta3 ? $resposta->userResposta3->nom . ' ' . $resposta->userResposta3->cognoms : null,
                    ],
                    'Alumne emisor' => [
                        'id' => $resposta->id_alumno_emisor,
                        'relacion' => $resposta->alumnoEmisor ? $resposta->alumnoEmisor->nom . ' ' . $resposta->alumnoEmisor->cognoms : null,
                    ],
                    'Curs alumne emisor' => [
                        'id' => $resposta->id_curs_alumno_emisor,
                        'relacion' => $resposta->curso ? $resposta->curso->name : null,
                    ],
                ];
            });
        
            return response()->json($respostasTransformadas);
        }


        public function show(Respostas $respostas) {}

        public function edit(Respostas $respostas) {}

        public function update(Request $request, Respostas $respostas) {}

        public function destroy(Respostas $respostas) {}

        public function verificarAlumno($id)
        {
            $exists = Respostas::where('id_alumno_emisor', $id)->exists();
    
            return response()->json([
                'Enquesta_resposta' => $exists,
            ]);
        }
    }