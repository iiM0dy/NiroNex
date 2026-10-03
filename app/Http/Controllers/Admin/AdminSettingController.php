<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function editFooter()
    {
        $settings = Setting::footer();

        return view('admin.settings.footer', compact('settings'));
    }

    public function updateFooter(Request $request)
    {
        $validated = $request->validate([
            'site_description' => ['nullable', 'string', 'max:1000'],
            'support_email' => ['nullable', 'email', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'telegram_url' => ['nullable', 'url', 'max:255'],
            'copyright_text' => ['nullable', 'string', 'max:255'],
        ]);

        $payload = [];

        foreach (array_keys(Setting::footerDefaults()) as $key) {
            $payload[$key] = trim((string) ($validated[$key] ?? ''));
        }

        Setting::updateFooter($payload);

        return redirect()
            ->route('admin.settings.footer.edit')
            ->with('success', 'تم تحديث بيانات الفوتر بنجاح.');
    }
}
