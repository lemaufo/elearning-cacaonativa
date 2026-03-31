<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        $courses = Course::with('creator')
            ->latest()
            ->paginate(15);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'area'        => 'nullable|string|max:100',
            'thumbnail'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $validated['created_by'] = Auth::id();
        $validated['status']     = 'draft';

        Course::create($validated);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso creado correctamente.');
    }

    public function edit(Course $course)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);
        $lessons = $course->lessons()->orderBy('order')->get();
        return view('admin.courses.edit', compact('course', 'lessons'));
    }

    public function update(Request $request, Course $course)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'area'        => 'nullable|string|max:100',
            'thumbnail'   => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($validated);

        return redirect()->route('admin.courses.edit', $course)
            ->with('success', 'Curso actualizado correctamente.');
    }

    public function destroy(Course $course)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Curso eliminado.');
    }

    public function updateStatus(Request $request, Course $course)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        $request->validate([
            'status' => 'required|in:draft,review,approved,published',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'published') {
            $data['approved_by'] = Auth::id();
        }

        $course->update($data);

        return back()->with('success', 'Estatus actualizado correctamente.');
    }
}