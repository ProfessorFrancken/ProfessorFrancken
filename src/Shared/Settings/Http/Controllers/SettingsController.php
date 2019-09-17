<?php

declare(strict_types=1);

namespace Francken\Shared\Settings\Http\Controllers;

use Francken\Shared\Settings\Settings;
use Illuminate\Http\Request;

class SettingsController
{
    /**
     * @var Settings
     */
    private $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function index()
    {
        return view('admin.compucie.settings.index', [
            'settings' => $this->settings,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Settings'],
            ]
        ]);
    }

    public function update(Request $request)
    {
        // Make sure that we only pass settings which are expected
        $this->settings->updateSettings(
            $request->only(
                array_keys(iterator_to_array($this->settings))
            )
        );

        return redirect()->action([static::class, 'index']);
    }
}
