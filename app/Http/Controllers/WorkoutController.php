<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Traits\HttpResponses;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkoutController extends Controller
{
    use HttpResponses;

    public function store(Request $request)
    {

        try {
            $data = $request->all();

            $request->validate([
                'student_id' => 'required',
                'exercise_id' => 'required',
                'repetitions' => 'required|int',
                'weight' => 'required|numeric',
                'break_time' => 'int|required',
                'day' => 'required|string|in:SEGUNDA,TERÇA,QUARTA, QUINTA,SEXTA,SÁBADO, DOMINGO',
                'observations' => 'string|max:500',
                'time' => 'int|required',
            ]);

            $existingWorkout = Workout::where('exercise_id', $data['exercise_id'])
                ->where('student_id', $data['student_id'])
                ->where('day', $data['day'])
                ->first();

            if ($existingWorkout) {
                return $this->error('Este treino já está cadastrado para este estudante nesta data', Response::HTTP_CONFLICT);
            }

            $workout = Workout::create($data);

            return $this->response("CREATED", Response::HTTP_CREATED, $data);
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
