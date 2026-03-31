<?php

namespace App\Http\Controllers\Colaborador;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\LessonProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $courses = Course::where('status', 'published')
            ->with(['enrollments' => function ($q) use ($user) {
                $q->where('user_id', $user->id);
            }, 'lessons'])
            ->withCount('lessons')
            ->get()
            ->map(function ($course) use ($user) {
                $enrollment = $course->enrollments->first();
                $completedLessons = 0;

                if ($enrollment && $course->lessons_count > 0) {
                    $completedLessons = LessonProgress::whereIn('lesson_id', $course->lessons->pluck('id'))
                        ->where('user_id', $user->id)
                        ->where('completed', true)
                        ->count();
                }

                $course->enrollment        = $enrollment;
                $course->progress_percent  = $course->lessons_count > 0
                    ? round(($completedLessons / $course->lessons_count) * 100)
                    : 0;

                return $course;
            });

        return view('colaborador.courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        abort_if($course->status !== 'published', 404);

        $user     = Auth::user();
        $lessons  = $course->lessons()->orderBy('order')->get();
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        $completedLessons = LessonProgress::whereIn('lesson_id', $lessons->pluck('id'))
            ->where('user_id', $user->id)
            ->where('completed', true)
            ->pluck('lesson_id')
            ->toArray();

        $progress = $lessons->count() > 0
            ? round((count($completedLessons) / $lessons->count()) * 100)
            : 0;

        $certificate = $user->certificates()->where('course_id', $course->id)->first();

        return view('colaborador.courses.show', compact(
            'course', 'lessons', 'enrollment', 'completedLessons', 'progress', 'certificate'
        ));
    }

    public function enroll(Course $course)
    {
        abort_if($course->status !== 'published', 404);

        $user = Auth::user();

        Enrollment::firstOrCreate(
            ['user_id' => $user->id, 'course_id' => $course->id],
            ['status' => 'in_progress', 'enrolled_at' => now()]
        );

        return redirect()->route('cursos.show', $course)
            ->with('success', 'Te has inscrito al curso correctamente.');
    }

    public function completeLesson(Course $course, $lessonId)
    {
        $user = Auth::user();

        $lesson = $course->lessons()->findOrFail($lessonId);

        LessonProgress::updateOrCreate(
            ['user_id' => $user->id, 'lesson_id' => $lesson->id],
            ['completed' => true, 'completed_at' => now()]
        );

        // Actualizar enrollment
        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($enrollment) {
            $totalLessons     = $course->lessons()->count();
            $completedCount   = LessonProgress::whereIn('lesson_id', $course->lessons->pluck('id'))
                ->where('user_id', $user->id)
                ->where('completed', true)
                ->count();

            if ($completedCount >= $totalLessons) {
                $enrollment->update(['status' => 'in_progress']);
            }
        }

        return back()->with('success', 'Lección marcada como completada.');
    }
}