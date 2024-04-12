<?php

declare(strict_types=1);

namespace Francken\Shared\Settings\Http\Controllers;

use Francken\Shared\Settings\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController
{
    private Settings $settings;

    public function __construct(Settings $settings)
    {
        $this->settings = $settings;
    }

    public function index() : View
    {
        return view('admin.compucie.settings.index', [
            'settings' => $this->settings,
            'breadcrumbs' => [
                ['url' => action([static::class, 'index']), 'text' => 'Settings'],
            ]
        ]);
    }

    public function update(Request $request) : RedirectResponse
    {
        $request->validate([
            "number_of_extern" => ['required'],
            "number_of_chair" => ['required'],
            "header_image" => ['required'],
            "private_albums" => ['required'],
            "navigation_show_login" => ['nullable', 'boolean'],
            "navigation_show_slef" => ['nullable', 'boolean'],
            "navigation_show_symposium" => ['nullable', 'boolean'],
            "navigation_show_pienter" => ['nullable', 'boolean'],
            "navigation_show_expedition" => ['nullable', 'boolean'],
            "navigation_show_bbd" => ['nullable', 'boolean'],
        ]);

        $settings = [
            "number_of_extern" => $request->input("number_of_extern"),
            "number_of_chair" => $request->input("number_of_chair"),
            "header_image" => $request->input("header_image"),
            "private_albums" => (bool)$request->input("private_albums"),
            "navigation_show_login" => (bool) $request->input("navigation_show_login"),
            "navigation_show_slef" => (bool) $request->input("navigation_show_slef"),
            "navigation_show_symposium" => (bool) $request->input("navigation_show_symposium"),
            "navigation_show_pienter" => (bool) $request->input("navigation_show_pienter"),
            "navigation_show_expedition" => (bool) $request->input("navigation_show_expedition"),
            "navigation_show_bbd" => (bool) $request->input("navigation_show_bbd"),
        ];

        // Make sure that we only pass settings which are expected
        $this->settings->updateSettings($settings);

        return redirect()->action([static::class, 'index']);
    }
}
