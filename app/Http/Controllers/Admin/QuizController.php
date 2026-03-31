<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Attempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index(Course $course)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);
        $quiz = $course->quiz()->with('questions.answers')->first();
        return view('admin.quizzes.index', compact('course', 'quiz'));
    }

    public function store(Request $request, Course $course)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        $request->validate([
            'title'       => 'required|string|max:255',
            'min_score'   => 'required|integer|min:1|max:100',
            'max_attempts'=> 'required|integer|min:1|max:10',
        ]);

        $course->quiz()->delete();

        Quiz::create([
            'course_id'    => $course->id,
            'title'        => $request->title,
            'min_score'    => $request->min_score,
            'max_attempts' => $request->max_attempts,
        ]);

        return back()->with('success', 'Evaluación creada.');
    }

    public function storeQuestion(Request $request, Quiz $quiz)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        $request->validate([
            'question_text'  => 'required|string',
            'answers'        => 'required|array|min:2',
            'answers.*.text' => 'required|string',
            'correct_answer' => 'required|integer',
        ]);

        $question = Question::create([
            'quiz_id'       => $quiz->id,
            'question_text' => $request->question_text,
            'order'         => $quiz->questions()->count() + 1,
        ]);

        foreach ($request->answers as $index => $answerData) {
            Answer::create([
                'question_id' => $question->id,
                'answer_text' => $answerData['text'],
                'is_correct'  => $index === (int) $request->correct_answer,
                'order'       => $index + 1,
            ]);
        }

        return back()->with('success', 'Pregunta agregada.');
    }

    public function destroyQuestion(Question $question)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);
        $question->delete();
        return back()->with('success', 'Pregunta eliminada.');
    }

    public function unlockAttempt(Request $request, Quiz $quiz, $userId)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        Attempt::where('quiz_id', $quiz->id)
            ->where('user_id', $userId)
            ->update(['blocked' => false, 'unlocked_by_admin' => true]);

        return back()->with('success', 'Intentos desbloqueados para el usuario.');
    }
}