<?php

declare(strict_types=1);

namespace Francken\Domain\Activities;

use Francken\Domain\DomainException;

final class InvalidActivity extends DomainException
{

    public static function cantCancelADraft()
    {
        return new static("Can't cancel an activity that is a draft or has been cancelled.");
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
