<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use App\Models\User;
use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleBeforeAction
{
    use ApiResponser;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        $userRole = $this->getUserRole($request->user());

        $errorMessage = "Não foi possível exibir dados desta seção";
        $errorStatus = Response::HTTP_FORBIDDEN;

        if ($userRole != Role::ADMIN->value) {
            if ($this->isAdminRoute()) {
                return $this->errorResponse($errorMessage, $errorStatus);
            }
        }

        return $next($request);
    }

    private function isAdminRoute(): bool
    {
        return in_array('manager', explode('/', Route::getCurrentRoute()->action['prefix']));
    }

    private function getUserRole(User $user): string
    {
        return $user->role;
    }
}
