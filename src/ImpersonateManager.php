<?php

namespace BaniTo\Impersonate;

use BaniTo\Impersonate\Contracts\Impersonatable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class ImpersonateManager
{
    public function isImpersonating()
    {
        return session()->has($this->sessionKey());
    }

    /**
     * @param Impersonatable|Authenticatable $from
     * @param Impersonatable|Authenticatable $to
     * @return bool
     */
    public function impersonate(Impersonatable $from, Impersonatable $to)
    {
        if (!$from->canImpersonate() || !$to->canBeImpersonated()) {
            return false;
        }

        Auth::guard($from->guardName())->logout();
        Auth::guard($to->guardName())->login($to);

        session()->put($this->sessionKey(), [
            'id' => $from->getAuthIdentifier(),
            'from_guard' => $from->guardName(),
        ]);

        return true;
    }

    public function stopImpersonating()
    {
        if (!$this->isImpersonating()) {
            return false;
        }

        ['id' => $id, 'from_guard' => $fromGuard] = session($this->sessionKey());

        Auth::guard(Auth::user()->guardName())->logout();
        Auth::guard($fromGuard)->loginUsingId($id);

        session()->forget($this->sessionKey());

        return true;
    }

    public function sessionKey()
    {
        return config('impersonate.session_key');
    }
}