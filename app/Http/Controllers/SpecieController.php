<?php

namespace App\Http\Controllers;

use App\Models\Specie as SpecieModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Exception;

class SpecieController extends Controller
{
    public function index()
    {
        try
        {
            $data = SpecieModel::get();
            $message = $this->response("Especie ".$data->name." encontrada com sucesso.", $data);
            return $this->response($message, $data);
        } catch (Exception $exception) {
            return $this->response($exception->getMessage(), null, false, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(Request $request)
    {
        try {
            $validator = ['name' => 'required|string|min:3|max:50'];
            $request->validate($validator);
            $data = SpecieModel::create($request->all());

            return $this->response("Especie ".$data->name." cadastrada com sucesso.", $data);

        } catch (Exception $exception) {
            return $this->response($exception->getMessage(), null, false, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(string $id)
    {
        try
        {
            $data = SpecieModel::find($id);

            if(empty($data)) {
                return $this->response('Especie não encontrada.', null, false, Response::HTTP_NOT_FOUND);
            }

            $message = "Especie ".$data->name." encontrada com sucesso.";
            return $this->response($message, $data);
        } catch (Exception $exception) {
            return $this->response($exception->getMessage(), null, false, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $validator = ['name' => ' string | min: 3 | max: 50'];

            $request->validate($validator);

            $data = SpecieModel::find($id);

            if(empty($data)) {
                return $this->response('Especie não encontrada.', null, false, Response::HTTP_NOT_FOUND);
            }

            $data->update($request->all());

            return $this->response("Especie ".$data->name." atualizada com sucesso.", $data);

        } catch (Exception $exception) {
            return $this->response($exception->getMessage(), null, false, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $id)
    {
        try
        {
            $data = SpecieModel::find($id);

            if(empty($data)) {
                return $this->response('Especie não encontrada.', null, false, Response::HTTP_NOT_FOUND);
            }

            SpecieModel::destroy($data->id);

            $message = "Especie ".$data->name." deletada com sucesso.";
            return $this->response($message, $data);
        } catch (Exception $exception) {
            return $this->response($exception->getMessage(), null, false, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
