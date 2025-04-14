<?php
    namespace App\Http\Controllers;

    use App\Models\Rol;
    use Illuminate\Http\Request;

    class RolController extends Controller {
        public function index() {
            $rol = Rol::select('id','name')->get();
            return response()->json($rol);
        }

        public function create() {
            //
        }

        public function store(Request $request) {
            //
        }

        public function show(Rol $rol) {
            //
        }

        public function edit(Rol $rol) {
            //
        }

        public function update(Request $request, Rol $rol) {
            //
        }

        public function destroy(Rol $rol) {
            //
        }
    }