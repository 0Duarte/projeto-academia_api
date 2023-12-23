<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Workout;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{
    use HttpResponses;

    public function store(Request $request){
        try{
            $data = $request->all();
            $request->validate([
                'description' => 'required|string|max:255',
            ]);
            $user_id = $request->user()->id;

            $existingExercise = Exercise::where('user_id', $user_id)
            ->where('description', $data['description'])
            ->first();

            if ($existingExercise) {
                return $this->error('Já existe um exercício com essa descrição para o usuário logado.', Response::HTTP_CONFLICT);
            }

            $exercise = Exercise::create([...$data,'user_id' => $user_id]);

            return $this->response("CREATED", Response::HTTP_CREATED, $exercise);

        } catch(Exception $exception){
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function index(Request $request){
        try{
            $exercises = Exercise::where('user_id', $request->user()->id)->orderBy('description')->get();

            return $exercises;
        } catch (Exception $exception){
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy(Request $request, $id){

        try{$exercise = Exercise::find($id);

            if(!$exercise) return $this->error('Exercício não encontrado', Response::HTTP_NOT_FOUND);

            $workoutsExist = Workout::where('exercise_id', $id)->first();

            if($workoutsExist) {
                return $this->error('Existe um treino cadastrado para esse exercício', Response::HTTP_CONFLICT);
                }

            if($exercise->user_id != $request->user()->id) {
            return $this->error('Este exercício pertence a outro usuário', Response::HTTP_FORBIDDEN);
            }

            $exercise->delete();

            return $this->response('',Response::HTTP_NO_CONTENT);
        } catch (Exception $exception){
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
    }
    }
}
