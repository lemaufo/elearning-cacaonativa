<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        $query = Enrollment::with(['user', 'course'])
            ->join('users', 'enrollments.user_id', '=', 'users.id')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->select('enrollments.*');

        if ($request->filled('user_id')) {
            $query->where('enrollments.user_id', $request->user_id);
        }

        if ($request->filled('course_id')) {
            $query->where('enrollments.course_id', $request->course_id);
        }

        if ($request->filled('status')) {
            $query->where('enrollments.status', $request->status);
        }

        $enrollments = $query->latest('enrollments.created_at')->paginate(20)->withQueryString();
        $users       = User::whereHas('roles', fn($q) => $q->where('name', 'colaborador'))->get();
        $courses     = Course::where('status', 'published')->get();

        return view('admin.reports.index', compact('enrollments', 'users', 'courses'));
    }

    public function export(Request $request)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        $query = Enrollment::with(['user', 'course'])
            ->join('users', 'enrollments.user_id', '=', 'users.id')
            ->join('courses', 'enrollments.course_id', '=', 'courses.id')
            ->select('enrollments.*');

        if ($request->filled('user_id')) {
            $query->where('enrollments.user_id', $request->user_id);
        }
        if ($request->filled('course_id')) {
            $query->where('enrollments.course_id', $request->course_id);
        }
        if ($request->filled('status')) {
            $query->where('enrollments.status', $request->status);
        }

        $enrollments = $query->latest('enrollments.created_at')->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="reporte-capacitacion-' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($enrollments) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8

            fputcsv($file, [
                'Colaborador', 'Email', 'Área',
                'Curso', 'Estatus', 'Inscrito el', 'Completado el',
            ]);

            foreach ($enrollments as $e) {
                fputcsv($file, [
                    $e->user->name,
                    $e->user->email,
                    $e->user->area ?? '—',
                    $e->course->title,
                    match($e->status) {
                        'not_started' => 'No iniciado',
                        'in_progress' => 'En progreso',
                        'approved'    => 'Aprobado',
                        'failed'      => 'Reprobado',
                        default       => $e->status,
                    },
                    $e->enrolled_at?->format('d/m/Y') ?? '—',
                    $e->completed_at?->format('d/m/Y') ?? '—',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}