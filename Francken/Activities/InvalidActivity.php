<?php

namespace Francken\Activities;

use Francken\Base\DomainException;

final class InvalidActivity extends DomainException {

    public static function cantRetractADraft()
    {
        return new static("Can't retract an activity that is a draft or has been retracted.");
    }

    public static function alreadyPublished()
    {
        return new static("The activity has already been published.");
    }

    public static function invalidCategory($category)
    {
        return new static("The given activity category, \"{$category}\", is not supported");
    }
}