<?php

namespace BaniTo\Impersonate\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;

interface Impersonatable
{
    /**
     * @return bool
     */
    public function canImpersonate() : bool;

    /**
     * @return bool
     */
    public function canBeImpersonated() : bool;

    /**
     * @return bool
     */
    public function isImpersonating();

    /**
     * @param Impersonatable|Authenticatable $user
     * @return bool
     */
    public function impersonate(Impersonatable $user);

    /**
     * @return bool
     */
    public function stopImpersonating();

    /**
     * @return string|null
     */
    public function guardName();
}