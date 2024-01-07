<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use App\Models\People;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfessionalsController extends Controller
{
    public function index()
    {
        $professionals = Professional::with('people')->get();
        return response()->json(['success' => true, 'data' => $professionals]);
    }

    public function show($id)
    {
        $professional = Professional::with('people')->find($id);

        if (!$professional) {
            return response()->json(['success' => false, 'message' => 'Profissional não encontrado'], 404);
        }

        return response()->json(['success' => true, 'data' => $professional]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|min:3',
                'cpf' => 'string|min:11',
                'contact' => 'string|min:11',
                'specialty' => 'required|string|max:50',
                'register' => 'string|max:20',
            ]);

            $people = People::firstOrCreate(
                ['name' => $request->input('name')],
                ['cpf' => $request->input('cpf'), 'contact' => $request->input('contact')]
            );

            $professional = Professional::create([
                'people_id' => $people->id,
                'specialty' => $request->input('specialty'),
                'register' => $request->input('register'),
            ]);

            return response()->json(['success' => true, 'data' => $professional], 201);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), null, false, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $professional = Professional::find($id);
    
            if (!$professional) {
                return response()->json(['success' => false, 'message' => 'Profissional não encontrado'], 404);
            }
    
            $request->validate([
                'name' => 'string|min:3',
                'cpf' => 'string|min:11',
                'contact' => 'string|min:11',
                'specialty' => 'string|max:50',
                'register' => 'string|max:20',
            ]);
    
            $people = People::where('name', $request->input('name'))->first();
    
            if (!$people) {
                $people = People::create([
                    'name' => $request->input('name'),
                    'cpf' => $request->input('cpf'),
                    'contact' => $request->input('contact'),
                ]);
            }
    
            $professional->update([
                'people_id' => $people->id,
                'specialty' => $request->input('specialty'),
                'register' => $request->input('register'),
            ]);
    
            return response()->json(['success' => true, 'data' => $professional]);
        } catch (\Exception $e) {
            return $this->response($e->getMessage(), null, false, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    public function destroy($id)
    {
        $professional = Professional::find($id);

        if (!$professional) {
            return response()->json(['success' => false, 'message' => 'Profissional não encontrado'], 404);
        }

        $professional->delete();

        return response()->json(['success' => true, 'message' => 'Profissional deletado com sucesso'], 204);
    }
}
