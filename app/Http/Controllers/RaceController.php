<?php

namespace App\Http\Controllers;

use App\Models\Race;
use Exception;
use Illuminate\Http\Request;

class RaceController extends Controller
{
    public function index() {
        $races = Race::all();
        return $races;
    }


    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|unique:races|max:50'
            ]);

            $data = $request->all();

            $race = Race::create($data);

            return $race;
        } catch (Exception $exception) {
            return $this->response($exception->getMessage(), null, false, 400);
        }
    }
}
