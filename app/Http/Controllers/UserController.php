<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    use HttpResponses;

    public function store(Request $request){
        try{
            $data=$request->all();

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'email|required|max:255|unique:users',
                'date_birth'=> 'date_format:Y-m-d|required',
                'cpf'=> 'string|required|max:14|unique:users',
                'password' => 'string|required|min:8|max:32',
                'plan_id'=> 'required|int',
            ]);

            $user = User::create($data);
            return $user;
        } catch(Exception $exception){
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);

        }
    }
}
