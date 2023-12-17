<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class StudentController extends Controller
{
    use HttpResponses;

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'email|required|max:255|unique:students',
                'date_birth'=> 'date_format:Y-m-d|required',
                'cpf'=> 'string|required|max:14|unique:students',
                'contact'=> 'string|required|max:20',
                'city'=> 'string|',
                'neighborhood'=> 'string',
                'number'=> 'string',
                'street'=> 'string',
                'state'=> 'string',
                'cep'=> 'string|required|max:14'
            ]);

            $user_id = $request->user()->id;
            $students = Student::create([...$data,'user_id' => $user_id]);

            return $this->response("CREATED", Response::HTTP_CREATED, $data);

        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
