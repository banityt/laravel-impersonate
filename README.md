# laravel-impersonate
Impersonate with multi auth guard support.

## Install
```bash
composer require banityt/laravel-impersonate
```

## Setup
* Implements Impersonatable Contract and use Impersonatable Trait in your user model.
```php
use BaniTo\Impersonate\Contracts\Impersonatable as ImpersonatableContract;
use BaniTo\Impersonate\Traits\Impersonatable as ImpersonatableTrait;

class User extends Authenticatable implements ImpersonatableContract
{
    use ImpersonatableTrait;
    
    //...
}
```

* Set your guard name in your user model
```php
public function guardName()
{
    return 'web';   // or any custom guard name specified in config/auth.php
}
```

* (Optional) You can customize your impersonation related rights
```php
public funcion canImpersonate() : bool
{
    return Bouncer::can('users_impersonate');
}

public function canBeImpersonated() : bool
{
    return !Bouncer::is('admin');
}
```


## Usage
Through user model or facade
```php
use Impersonate;

// Impersonate other user, can be another user with other guard
auth()->user()->impersonate($anotherUser);
Auth::user()->impersonate($otherGuardUser);
Impersonate::impersonate($impersonator, $beingImpersonated);

// Stop impersonating
auth()->user()->stopImpersonating();
Auth::user()->stopImpersonating();
Impersonate::stopImpersonating();
```

Check if user is impersonating
```php
auth()->user()->isImpersonating();
Auth::user()->isImpersonating();
Impersonate::isImpersonating();

// blade example
@if (Impersonate::isImpersonating())
    <a href="{{route('your.route.impersonate.stop')}}">{{__('Stop Impersonation')}}</a>
@endif
```