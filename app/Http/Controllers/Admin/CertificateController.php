<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function verify()
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);
        return view('admin.certificates.verify', ['certificate' => null, 'searched' => false]);
    }

    public function check(Request $request)
    {
        abort_if(!Auth::user()->hasRole('admin'), 403);

        $request->validate([
            'uuid' => 'required|string',
        ]);

        $certificate = Certificate::where('uuid', trim($request->uuid))
            ->with(['user', 'course'])
            ->first();

        return view('admin.certificates.verify', [
            'certificate' => $certificate,
            'searched'    => true,
            'uuid'        => $request->uuid,
        ]);
    }
}