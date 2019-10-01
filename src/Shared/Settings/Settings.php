<?php

declare(strict_types=1);

namespace Francken\Shared\Settings;

use IteratorAggregate;

interface Settings extends IteratorAggregate
{
    public function updateSettings(array $settings) : void;

    public function contactNumberOfExtern() : string;

    public function areAlbumsPrivate() : bool;

    public function headerImage() : string;

    /**
     * Show menu items
     */
    public function isLoginShownInNavigation() : bool;

    public function isSlefShownInNavigation() : bool;

    public function isSymposiumShownInNavigation() : bool;

    public function isPienterShownInNavigation() : bool;

    public function isLustrumShownInNavigation() : bool;

    public function isExpeditionShownInNavigation() : bool;
}
