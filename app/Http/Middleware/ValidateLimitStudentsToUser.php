<?php

namespace App\Http\Middleware;

use App\Models\Student;
use App\Traits\HttpResponses;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateLimitStudentsToUser
{
    use HttpResponses;

    public function handle(Request $request, Closure $next): Response
    {
        $registered_students = Student::where('user_id', $request->user()->id)->count();

        $plan = $request->user()->plan_id;
        $MaxLimit = false;

            if ($plan === 1 && $registered_students == 10){
                $MaxLimit = true;
            } else if($plan === 2 && $registered_students == 20){
                $MaxLimit = true;
            }

            if($MaxLimit){
                return $this->error('O usuário atingiu o limite de estudantes', response::HTTP_FORBIDDEN);
            }
        return $next($request);
    }
}
