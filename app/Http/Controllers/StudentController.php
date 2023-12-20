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
                'date_birth' => 'date_format:Y-m-d|required',
                'cpf' => 'string|required|max:14|unique:students',
                'contact' => 'string|required|max:20',
                'city' => 'string|',
                'neighborhood' => 'string',
                'number' => 'string',
                'street' => 'string',
                'state' => 'string',
                'cep' => 'string|required|max:14'
            ]);

            $user_id = $request->user()->id;
            $students = Student::create([...$data, 'user_id' => $user_id]);

            return $this->response("CREATED", Response::HTTP_CREATED, $data);
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    public function index(Request $request){

        try{ $students = Student::query();
            $search=$request->query();

            if ($request->has('name') && !empty($search['name'])) {
                $students->where('name', 'ilike', '%' . $search['name'] . '%');
            }

            if ($request->has('email') && !empty($search['email'])) {
                $students->where('email', 'ilike', '%' . $search['email'] . '%');
            }

            if ($request->has('cpf') && !empty($search['cpf'])) {
                $students->where('cpf', 'ilike', '%' . $search['cpf'] . '%');
            }
            return $students->orderBy('name')->get();
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Request $request, $id)
    {

        try {
            $student = Student::find($id);

            if (!$student) return $this->error('Estudante não encontrado', Response::HTTP_NOT_FOUND);

            if ($student->user_id != $request->user()->id) {
                return $this->error('Este estudante pertence a outro usuário', Response::HTTP_FORBIDDEN);
            }

            $student->delete();

            return $this->response('', Response::HTTP_NO_CONTENT);
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    public function update($id, Request $request)
    {
        try {
            $data = $request->only('name', 'email', 'date_birth', 'cpf', 'contact', 'city', 'neighborhood', 'number', 'street', 'state', 'complement', 'contact');
            $request->validate([
                "name" => "string|max:255",
                "email" => "string|email|max:255|unique:students",
                "date_birth" => 'string|date_format:Y-m-d|',
                "cpf" => "string|max:14|unique:students",
                "cep" => "string",
                "street" => "string",
                "neighborhood" => "string",
                "city" => "string",
                "state" => "string",
                "complement" => "string",
                "number" => "string",
                "contact" => "string|max:20|"
            ]);
            $student = Student::find($id);

            if (!$student) return $this->error('Estudante não encontrado', Response::HTTP_NOT_FOUND);

            if ($student->user_id != $request->user()->id) {
                return $this->error('Este estudante pertence a outro usuário', Response::HTTP_FORBIDDEN);
            }

            $student->update($data);

            return $student;
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
