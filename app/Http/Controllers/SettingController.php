<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    public function edit(): Response
    {
        $settings = Setting::allAsArray();

        return Inertia::render('Settings/Edit', [
            'settings' => [
                'app_name' => $settings['app_name'] ?? '',
                'app_tagline' => $settings['app_tagline'] ?? '',
                'support_email' => $settings['support_email'] ?? '',
                'timezone' => $settings['timezone'] ?? 'UTC',
                'primary_color' => $settings['primary_color'] ?? '#5f63f2',
                'default_theme' => $settings['default_theme'] ?? 'light',
                'sidebar_default_collapsed' => (bool) ($settings['sidebar_default_collapsed'] ?? false),
                'notify_new_user' => (bool) ($settings['notify_new_user'] ?? false),
                'notify_weekly_report' => (bool) ($settings['notify_weekly_report'] ?? false),
                'notify_product_updates' => (bool) ($settings['notify_product_updates'] ?? false),
            ],
            'timezones' => ['UTC', 'America/New_York', 'Europe/London', 'Asia/Manila', 'Asia/Tokyo', 'Australia/Sydney'],
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'app_name' => ['required', 'string', 'max:255'],
            'app_tagline' => ['nullable', 'string', 'max:255'],
            'support_email' => ['nullable', 'email', 'max:255'],
            'timezone' => ['required', 'string', 'max:64'],
            'primary_color' => ['required', 'string', 'max:20'],
            'default_theme' => ['required', 'in:light,dark'],
            'sidebar_default_collapsed' => ['boolean'],
            'notify_new_user' => ['boolean'],
            'notify_weekly_report' => ['boolean'],
            'notify_product_updates' => ['boolean'],
        ]);

        Setting::setMany($validated);

        return back()->with('success', 'Settings saved successfully.');
    }
}
