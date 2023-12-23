<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\student;
use App\Models\User;
use App\Traits\HttpResponses;
use Exception;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DashboardController extends Controller
{
    use HttpResponses;

    public function index(Request $request){

        try{$registered_students = Student::where('user_id', $request->user()->id)->count();
            $registered_exercises = Exercise::where('user_id', $request->user()->id)->count();
            $plan = $request->user()->plan_id;

            if ($plan === 1){
                $current_user_plan = 'Plano Bronze';
                $remaining_students = 10 - $registered_students;
            } else if($plan === 2){
                $current_user_plan = 'Plano Prata';
                $remaining_students = 20 - $registered_students;

            } else {
                $current_user_plan = 'Plano Ouro';
                $remaining_students = 'ILIMITADO';

            }

            return $this->response('OK', 200, [
                'registered_students' => $registered_students,
                'registered_exercises' => $registered_exercises,
                'current_user_plan' => $current_user_plan,
                'remaining_students' => $remaining_students
            ]);
        } catch(Exception $exception){
            return $this->error($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

    }
}
