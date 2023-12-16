<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\student;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use HttpResponses;

    public function index(Request $request){

            $registered_students = Student::where('user_id', $request->user()->id)->count();
            $registered_exercises = Exercise::where('user_id', $request->user()->id)->count();
            $plan = $request->user()->plan_id;

            if ($plan === 1){
                $current_user_plan = 'BRONZE';
                $remaining_estudants = 10 - $registered_students;
            } else if($plan === 2){
                $current_user_plan = 'PRATA';
                $remaining_estudants = 20 - $registered_students;

            } else {
                $current_user_plan = 'OURO';
                $remaining_estudants = 'ILIMITADO';

            }

            return $this->response('OK', 200, [
                'registered_students' => $registered_students,
                'registered_exercises' => $registered_exercises,
                'current_user_plan' => $current_user_plan,
                'remaining_estudants' => $remaining_estudants
            ]);

    }
}
