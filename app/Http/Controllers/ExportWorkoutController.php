<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Traits\HttpResponses;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExportWorkoutController extends Controller
{
    use HttpResponses;

    public function exportWorkoutPdf(Request $request)
    {
        $id = $request->input('id');
        $student = Student::with('workouts.exercise')->find($id);

        if (!$student) {
            return $this->error('Este estudante não existe', Response::HTTP_NOT_FOUND);
        }

        $workoutsReturn = [
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

        foreach ($student->workouts as $item) {
            $workoutsReturn['workouts'][$item['day']][] = $item;
        }

        $pdf = Pdf::loadView('pdfs.workoutPdf', $workoutsReturn);


       return $pdf->stream('workoutPdf.pdf');
    }
}
