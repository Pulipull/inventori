<?php

namespace App\Http\Controllers;

use App\Models\NotificationPreference;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationPreferenceController extends Controller
{
    public function edit(Request $request): View
    {
        return view('notifications.preferences', [
            'preferences' => $this->preferencesFor($request),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'low_stock_enabled' => ['nullable', 'boolean'],
            'crm_enabled' => ['nullable', 'boolean'],
            'report_enabled' => ['nullable', 'boolean'],
            'system_enabled' => ['nullable', 'boolean'],
        ]);

        $this->preferencesFor($request)->update([
            'low_stock_enabled' => (bool) ($data['low_stock_enabled'] ?? false),
            'crm_enabled' => (bool) ($data['crm_enabled'] ?? false),
            'report_enabled' => (bool) ($data['report_enabled'] ?? false),
            'system_enabled' => (bool) ($data['system_enabled'] ?? false),
        ]);

        return redirect()->route('notification-preferences.edit')->with('success', 'Preferensi notifikasi berhasil diperbarui.');
    }

    private function preferencesFor(Request $request): NotificationPreference
    {
        return NotificationPreference::firstOrCreate(['user_id' => $request->user()->id]);
    }
}
