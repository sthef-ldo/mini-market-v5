<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse;

class LoginResponseCustom implements LoginResponse
{
    public function toResponse($request)
    {
        $user = $request->user();

        return match ($user->rol ?? null) {
            'cliente' => redirect()->route('catalogo.index'),
            'admin'   => redirect()->route('dashboard'),
            default   => redirect()->intended(config('fortify.home', '/')),
        };
    }
}
