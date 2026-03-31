<?php

namespace App\Http\Controllers\Colaborador;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Attempt;
use App\Models\AttemptAnswer;
use App\Models\Certificate;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    public function show(Course $course)
    {
        $quiz = $course->quiz;
        abort_if(!$quiz, 404);

        $user       = Auth::user();
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $attempts      = $quiz->attemptsFor($user)->count();
        $lastAttempt   = $quiz->attemptsFor($user)->latest()->first();
        $isBlocked     = $attempts >= $quiz->max_attempts
                         && !$quiz->attemptsFor($user)->where('unlocked_by_admin', true)->where('finished_at', null)->exists();
        $hasCertificate = Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)->exists();

        if ($hasCertificate) {
            return redirect()->route('cursos.show', $course)
                ->with('success', 'Ya aprobaste este curso.');
        }

        if ($isBlocked) {
            return redirect()->route('cursos.show', $course)
                ->with('error', 'Has agotado tus intentos. Contacta al administrador para desbloquear.');
        }

        $questions = $quiz->questions()->with('answers')->get();

        return view('colaborador.quiz.show', compact(
            'course', 'quiz', 'questions', 'attempts', 'lastAttempt', 'isBlocked'
        ));
    }

    public function submit(Request $request, Course $course)
    {
        $quiz = $course->quiz;
        abort_if(!$quiz, 404);

        $user    = Auth::user();
        $attempts = $quiz->attemptsFor($user)->count();
        $isBlocked = $attempts >= $quiz->max_attempts
                     && !$quiz->attemptsFor($user)->where('unlocked_by_admin', true)->where('finished_at', null)->exists();

        abort_if($isBlocked, 403);

        // Crear intento
        $attempt = Attempt::create([
            'user_id'    => $user->id,
            'quiz_id'    => $quiz->id,
            'started_at' => now(),
        ]);

        // Guardar respuestas y calcular puntaje
        $questions   = $quiz->questions()->with('answers')->get();
        $correctCount = 0;

        foreach ($questions as $question) {
            $answerId = $request->input('answers.' . $question->id);

            AttemptAnswer::create([
                'attempt_id'  => $attempt->id,
                'question_id' => $question->id,
                'answer_id'   => $answerId,
            ]);

            $correctAnswer = $question->correctAnswer();
            if ($correctAnswer && (int) $answerId === $correctAnswer->id) {
                $correctCount++;
            }
        }

        $score  = $questions->count() > 0
            ? round(($correctCount / $questions->count()) * 100)
            : 0;
        $passed = $score >= $quiz->min_score;

        $attempt->update([
            'score'       => $score,
            'passed'      => $passed,
            'finished_at' => now(),
        ]);

        // Bloquear si agotó intentos
        $totalAttempts = $quiz->attemptsFor($user)->count();
        if (!$passed && $totalAttempts >= $quiz->max_attempts) {
            $attempt->update(['blocked' => true]);
        }

        // Generar certificado si aprobó
        if ($passed) {
            $this->generateCertificate($user, $course, $attempt, $score);

            Enrollment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->update(['status' => 'approved', 'completed_at' => now()]);
        }

        return redirect()->route('cursos.show', $course)->with(
            $passed ? 'success' : 'error',
            $passed
                ? "¡Felicitaciones! Aprobaste con {$score}%. Tu certificado está disponible."
                : "Obtuviste {$score}%. Necesitas {$quiz->min_score}% para aprobar."
        );
    }

    public function certificate(Course $course)
    {
        $user        = Auth::user();
        $certificate = Certificate::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->with(['course', 'user'])
            ->firstOrFail();

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.certificate', compact('certificate'));
        $pdf->setPaper('letter', 'landscape');

        return $pdf->download("certificado-{$course->title}-{$user->name}.pdf");
    }

    private function generateCertificate($user, $course, $attempt, $score)
    {
        Certificate::firstOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            [
                'attempt_id' => $attempt->id,
                'uuid'       => Str::uuid(),
                'score'      => $score,
                'issued_at'  => now(),
            ]
        );
    }
}