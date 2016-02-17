<?php

namespace Francken\Activities;

use Francken\Base\DomainException;

final class InvalidActivity extends DomainException {

    public static function invalidCategory($category)
    {
        return new static("The given activity category, \"{$category}\", is not supported");
    }
}