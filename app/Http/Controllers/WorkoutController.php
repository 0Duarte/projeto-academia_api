<?php

namespace App\Http\Controllers;

use App\Models\Student;
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
                'student_id' => 'required|int',
                'exercise_id' => 'required|int',
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
    public function show(Request $request)
    {
        try {
            $search = $request->input('id');
            $studentValidate = Student::find($search);

            if(!$studentValidate){
                return $this->error('Este estudante não existe', Response::HTTP_NOT_FOUND);
            }

            $student = Student::with([
                'workouts' => function ($query) {
                    $query->select(
                        'student_id',
                        'exercise_id',
                        'break_time',
                        'repetitions',
                        'weight',
                        'time',
                        'observations',
                        'day'
                    )->orderBy('created_at');
                }
            ])
                ->select('id', 'name')
                ->find($search);

            $array = $student->workouts;

            $studentnew = [
                'student_id' => $student['id'],
                'student_name' => $student['name'],
                'workouts' => [
                    "SEGUNDA" => [],
                    "TERÇA" => [],
                    "QUARTA" => [],
                    "QUINTA" => [],
                    "SEXTA" => [],
                    "SÁBADO" => [],
                    "DOMINGO" => [],
                ]
            ];

            foreach ($array as $item){
                if($item['day'] == 'SEGUNDA'){
                    $studentnew['workouts']['SEGUNDA'][]= $item;
                }
                else if($item['day'] == 'TERÇA'){
                    $studentnew['workouts']['TERÇA'][]= $item;
                }
                else if($item['day'] == 'QUARTA'){
                    $studentnew['workouts']['QUARTA'][]= $item;
                }
                else if($item['day'] == 'QUINTA'){
                    $studentnew['workouts']['QUINTA'][]= $item;
                }
                else if($item['day'] == 'SEXTA'){
                    $studentnew['workouts']['SEXTA'][]= $item;
                }
                else if($item['day'] == 'SÁBADO'){
                    $studentnew['workouts']['SÁBADO'][]= $item;
                }
                else if($item['day'] == 'DOMINGO'){
                    $studentnew['workouts']['DOMINGO'][]= $item;
                }
            }


            return $studentnew;
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}
