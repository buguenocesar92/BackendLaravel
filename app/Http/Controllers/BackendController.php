<?php

namespace App\Http\Controllers;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class BackendController extends Controller
{
    private $names = [
        1 => ["name" => "ana", "age"=> 30],
        2 => ["name" => "cesar", "age"=> 20],
        3 => ["name" => "juan", "age"=> 25],
    ];


    public function getAll(){

        return response()->json($this->names);
    }


    public function index(int $id = 0){
        if(isset($this->names[$id])){
            return response()->json($this->names[$id]);
        }

        return response()->json(["error"=> "persona no existente"], Response::HTTP_NOT_FOUND);
    }

    public function create(Request $request){
        $person = [
            "id" => count(($this->names)) + 1,
            "name" => $request->input("name"),
            "age"=> $request->input("age"),
        ];

        $this->names[$person["id"]] = $person;
        return response()->json($person, Response::HTTP_CREATED);
    }


    public function update(Request $request, $id){
        if(isset($this->names[$id])){
            $this->names[$id]["name"] = $request->input("name", $this->names[$id]["name"]);
            $this->names[$id]["age"] = $request->input("age", $this->names[$id]["age"]);
            
            return response()->json(['message' => 'persona actualizada',
                                    'person' => $this->names[$id]]);
        }
        
        return response()->json(["error"=> "persona no existente"], Response::HTTP_NOT_FOUND);
    }

    public function delete(int $id){
        if(isset($this->names[$id])){
            unset($this->names[$id]);
            return response()->json(["message"=> "persona eliminada"]);
        }

        return response()->json(["error"=> "persona no existente"], Response::HTTP_NOT_FOUND);
    }
}
