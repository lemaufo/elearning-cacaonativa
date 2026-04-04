<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Certificate;
use App\Models\Attempt;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        $stats = [
            'total_users'       => User::where('active', true)->count(),
            'total_courses'     => Course::where('status', 'published')->count(),
            'total_enrollments' => Enrollment::count(),
            'total_certs'       => Certificate::count(),
            'in_progress'       => Enrollment::where('status', 'in_progress')->count(),
            'approved'          => Enrollment::where('status', 'approved')->count(),
            'pending_review'    => Course::where('status', 'review')->count(),
            'avg_score'         => round(Attempt::where('passed', true)->avg('score') ?? 0),
        ];

        $recentCertificates = Certificate::with(['user', 'course'])
            ->latest('issued_at')
            ->take(5)
            ->get();

        $courseProgress = Course::where('status', 'published')
            ->withCount([
                'enrollments',
                'enrollments as approved_count' => fn($q) => $q->where('status', 'approved'),
            ])
            ->having('enrollments_count', '>', 0)
            ->orderByDesc('enrollments_count')
            ->take(6)
            ->get()
            ->map(function ($course) {
                $course->completion_rate = $course->enrollments_count > 0
                    ? round(($course->approved_count / $course->enrollments_count) * 100)
                    : 0;
                return $course;
            });

        $userProgress = User::with(['enrollments.course'])
            ->whereHas('roles', fn($q) => $q->where('name', 'colaborador'))
            ->where('active', true)
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($user) {
                $user->total_enrollments = $user->enrollments->count();
                $user->approved_courses  = $user->enrollments->where('status', 'approved')->count();
                $user->in_progress       = $user->enrollments->where('status', 'in_progress')->count();
                return $user;
            });

        return view('admin.dashboard', compact(
            'stats', 'recentCertificates', 'courseProgress', 'userProgress'
        ));
    }
}