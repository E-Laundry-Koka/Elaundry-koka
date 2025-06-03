<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;
use Symfony\Component\HttpFoundation\Response;

class VerifyIsSupervisor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role_id = $request->user()->role_id;
        $supervisorId = Role::where('role_name', 'supervisor')->first()->id;

        if($role_id != $supervisorId) {
            Swal::error([
                'title' => 'Anda tidak memiliki akses',
            ]);
            return redirect()->route('dashboard');
        }
        return $next($request);
    }
}
