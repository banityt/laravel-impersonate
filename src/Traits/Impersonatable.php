<?php

namespace BaniTo\Impersonate\Traits;


use BaniTo\Impersonate\Contracts\Impersonatable as ImpersonatableContract;
use BaniTo\Impersonate\ImpersonateManager;

trait Impersonatable
{
    public function canImpersonate() : bool
    {
        return true;
    }

    public function canBeImpersonated() : bool
    {
        return true;
    }

    public function isImpersonating()
    {
        return app();
    }

    public function impersonate(ImpersonatableContract $user)
    {
        return app(ImpersonateManager::class)->impersonate($this, $user);
    }

    public function stopImpersonating()
    {
        return app(ImpersonateManager::class)->stopImpersonating();
    }
}