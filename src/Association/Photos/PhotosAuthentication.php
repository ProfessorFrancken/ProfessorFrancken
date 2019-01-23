<?php


declare(strict_types=1);

namespace Francken\Association\Photos;

use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Session\Store;

/**
 * We use this class to check whether someone has succesfully loged into the
 * private photos section
 */
class PhotosAuthentication
{
    private const SESSION_KEY = 'authenticated-for-viewing-albums';

    /**
     * @var Store
     */
    private $sessions;

    /**
     * @var Hasher
     */
    private $hasher;

    /**
     * @var string
     */
    private $password_hash;

    public function __construct(Store $sessions, Hasher $hasher, string $password_hash)
    {
        $this->sessions = $sessions;
        $this->hasher = $hasher;
        $this->password_hash = $password_hash;
    }

    public function isLoggedIn() : bool
    {
        return $this->sessions->get(self::SESSION_KEY, false);
    }

    public function login(string $password) : bool
    {
        if ($this->hasher->check($password, $this->password_hash)) {
            $this->sessions->put(self::SESSION_KEY, true);

            return true;
        }

        return false;
    }
}
