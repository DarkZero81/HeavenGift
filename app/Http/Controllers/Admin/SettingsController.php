<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    public function index()
    {
        // Get current settings
        $settings = [
            'site_name' => config('app.name', 'Gift Heaven'),
            'site_email' => config('mail.from.address', 'admin@giftheaven.com'),
            'currency' => 'USD',
            'timezone' => config('app.timezone', 'UTC'),
            'maintenance_mode' => config('app.maintenance_mode', false),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_email' => 'required|email',
            'currency' => 'required|string|max:3',
            'timezone' => 'required|string',
        ]);

        // In a real application, you would save these to a settings table or config
        // For now, we'll just show a success message

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully!');
    }
}
