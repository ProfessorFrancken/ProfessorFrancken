<?php

declare(strict_types=1);

namespace Francken\Shared\Settings;

use Spatie\Valuestore\Valuestore;
use Traversable;

/**
 * This class acts as a wrapper around a Spatie\ValueStore\ValueStore
 */
final class ValueStoreSettings implements Settings
{
    /**
     * @var string
     */
    private const NUMBER_OF_EXTERN = 'number_of_extern';
    /**
     * @var string
     */
    private const HEADER_IMAGE = 'header_image';
    /**
     * @var string
     */
    private const PRIVATE_ALBUMS = 'private_albums';
    /**
     * @var string
     */
    private const IS_LOGIN_SHOWN_IN_NAVIGATION = 'navigation_show_login';
    /**
     * @var string
     */
    private const IS_SLEF_SHOWN_IN_NAVIGATION = 'navigation_show_slef';
    /**
     * @var string
     */
    private const IS_SYMPOSIUM_SHOWN_IN_NAVIGATION = 'navigation_show_symposium';
    /**
     * @var string
     */
    private const IS_PIENTER_SHOWN_IN_NAVIGATION = 'navigation_show_pienter';
    /**
     * @var string
     */
    private const IS_LUSTRUM_SHOWN_IN_NAVIGATION = 'navigation_show_lustrum';
    /**
     * @var string
     */
    private const IS_EXPEDITION_SHOWN_IN_NAVIGATION = 'navigation_show_expedition';

    private Valuestore $store;

    public function __construct(Valuestore $store)
    {
        $this->store = $store;
    }

    public function updateSettings(array $settings) : void
    {
        $allowed_keys = [
            static::NUMBER_OF_EXTERN,
            static::HEADER_IMAGE,
            static::PRIVATE_ALBUMS,
            static::IS_LOGIN_SHOWN_IN_NAVIGATION,
            static::IS_SLEF_SHOWN_IN_NAVIGATION,
            static::IS_SYMPOSIUM_SHOWN_IN_NAVIGATION,
            static::IS_PIENTER_SHOWN_IN_NAVIGATION,
            static::IS_LUSTRUM_SHOWN_IN_NAVIGATION,
            static::IS_EXPEDITION_SHOWN_IN_NAVIGATION,
        ];

        foreach ($settings as $key => $value) {
            // We don't want to store settings that aren't supported
            if ( ! in_array($key, $allowed_keys, true)) {
                continue;
            }
            $this->store->put($key, $value);
        }
    }

    public function contactNumberOfExtern() : string
    {
        $number = $this->store->get(self::NUMBER_OF_EXTERN);

        if ( ! is_string($number)) {
            return '';
        }

        return $number;
    }

    public function areAlbumsPrivate() : bool
    {
        $value = $this->store->get(self::PRIVATE_ALBUMS);

        if ($value === null) {
            return false;
        }

        return (bool) $value;
    }

    public function headerImage() : string
    {
        $header_image = $this->store->get(self::HEADER_IMAGE);

        if ( ! is_string($header_image)) {
            return '';
        }

        return $header_image;
    }

    /**
     * Show menu items
     */
    public function isLoginShownInNavigation() : bool
    {
        $value = $this->store->get(self::IS_LOGIN_SHOWN_IN_NAVIGATION);

        if ($value === null) {
            return false;
        }

        return (bool) $value;
    }

    public function isSlefShownInNavigation() : bool
    {
        $value = $this->store->get(self::IS_SLEF_SHOWN_IN_NAVIGATION);

        if ($value === null) {
            return false;
        }

        return (bool) $value;
    }

    public function isSymposiumShownInNavigation() : bool
    {
        $value = $this->store->get(self::IS_SYMPOSIUM_SHOWN_IN_NAVIGATION);

        if ($value === null) {
            return false;
        }

        return (bool) $value;
    }

    public function isPienterShownInNavigation() : bool
    {
        $value = $this->store->get(self::IS_PIENTER_SHOWN_IN_NAVIGATION);

        if ($value === null) {
            return false;
        }

        return (bool) $value;
    }

    public function isLustrumShownInNavigation() : bool
    {
        $value = $this->store->get(self::IS_LUSTRUM_SHOWN_IN_NAVIGATION);

        if ($value === null) {
            return false;
        }

        return (bool) $value;
    }

    public function isExpeditionShownInNavigation() : bool
    {
        $value = $this->store->get(self::IS_EXPEDITION_SHOWN_IN_NAVIGATION);

        if ($value === null) {
            return false;
        }

        return (bool) $value;
    }

    public function getIterator() : Traversable
    {
        yield static::NUMBER_OF_EXTERN => [
            'text' => 'Telephone number of extern',
            'value' => $this->contactNumberOfExtern(),
            'type' => 'text'
        ];
        yield static::HEADER_IMAGE => [
            'text' => 'URL to the image used in our homepage header',
            'value' => $this->headerImage(),
            'type' => 'text'
        ];
        yield static::PRIVATE_ALBUMS => [
            'text' => 'Members must be logged in to view albums/photos',
            'value' => $this->areAlbumsPrivate(),
            'type' => 'toggle'
        ];
        yield static::IS_LOGIN_SHOWN_IN_NAVIGATION => [
            'text' => 'Show a login button in the navigation menu',
            'value' => $this->isLoginShownInNavigation(),
            'type' => 'toggle'
        ];
        yield static::IS_SLEF_SHOWN_IN_NAVIGATION => [
            'text' => 'Add a link to slef.nl in the navigation menu',
            'value' => $this->isSlefShownInNavigation(),
            'type' => 'toggle'
        ];
        yield static::IS_SYMPOSIUM_SHOWN_IN_NAVIGATION => [
            'text' => 'Add a link to franckensymposium.nl in the navigation menu',
            'value' => $this->isSymposiumShownInNavigation(),
            'type' => 'toggle'
        ];
        yield static::IS_PIENTER_SHOWN_IN_NAVIGATION => [
            'text' => 'Add a link to pienterkamp.nl in the navigation menu',
            'value' => $this->isPienterShownInNavigation(),
            'type' => 'toggle'
        ];
        yield static::IS_LUSTRUM_SHOWN_IN_NAVIGATION => [
            'text' => 'Add a link to the lustrum page in the navigation menu',
            'value' => $this->isLustrumShownInNavigation(),
            'type' => 'toggle'
        ];
        yield static::IS_EXPEDITION_SHOWN_IN_NAVIGATION => [
            'text' => 'Add a link to expedition strategy in the navigation menu',
            'value' => $this->isExpeditionShownInNavigation(),
            'type' => 'toggle'
        ];
    }
}
