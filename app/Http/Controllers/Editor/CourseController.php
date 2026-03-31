<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        abort_if(!Auth::user()->hasAnyRole(['admin', 'editor']), 403);

        $user    = Auth::user();
        $courses = Auth::user()->hasRole('admin')
            ? Course::with('creator')->latest()->paginate(15)
            : Course::where('created_by', $user->id)
                ->orWhere('area', $user->area)
                ->with('creator')->latest()->paginate(15);

        return view('editor.courses.index', compact('courses'));
    }

    public function create()
    {
        abort_if(!Auth::user()->hasAnyRole(['admin', 'editor']), 403);
        return view('editor.courses.create');
    }

    public function store(Request $request)
    {
        abort_if(!Auth::user()->hasAnyRole(['admin', 'editor']), 403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'area'        => 'nullable|string|max:100',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status']     = 'draft';

        $course = Course::create($validated);

        return redirect()->route('editor.courses.edit', $course)
            ->with('success', 'Curso creado. Ahora agrega las lecciones.');
    }

    public function edit(Course $course)
    {
        abort_if(!Auth::user()->hasAnyRole(['admin', 'editor']), 403);
        $lessons = $course->lessons()->orderBy('order')->get();
        return view('editor.courses.edit', compact('course', 'lessons'));
    }

    public function update(Request $request, Course $course)
    {
        abort_if(!Auth::user()->hasAnyRole(['admin', 'editor']), 403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'area'        => 'nullable|string|max:100',
        ]);

        $course->update($validated);

        // Guardar lecciones
        if ($request->has('lessons')) {
            $course->lessons()->delete();
            foreach ($request->lessons as $index => $lessonData) {
                if (!empty($lessonData['title'])) {
                    Lesson::create([
                        'course_id'    => $course->id,
                        'title'        => $lessonData['title'],
                        'description'  => $lessonData['description'] ?? null,
                        'type'         => $lessonData['type'] ?? 'video',
                        'content_url'  => $lessonData['content_url'] ?? null,
                        'content_text' => $lessonData['content_text'] ?? null,
                        'order'        => $index + 1,
                    ]);
                }
            }
        }

        return back()->with('success', 'Curso guardado correctamente.');
    }

    public function submit(Course $course)
    {
        abort_if(!Auth::user()->hasAnyRole(['admin', 'editor']), 403);

        $course->update(['status' => 'review']);

        return back()->with('success', 'Curso enviado a revisión.');
    }

    public function destroy(Course $course)
    {
        abort_if(!Auth::user()->hasAnyRole(['admin', 'editor']), 403);
        $course->delete();
        return redirect()->route('editor.courses.index')
            ->with('success', 'Curso eliminado.');
    }
}