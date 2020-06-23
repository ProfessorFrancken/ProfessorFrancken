BaseEncrypter?php

declare(strict_types=1);

namespace Francken\Shared\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as BaseEncrypter;

class EncryptCookies extends BaseEncrypter
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<array-key, mixed>
     */
    protected $except = [
        //
    ];
}
void