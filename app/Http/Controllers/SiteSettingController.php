<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SiteSettingController extends Controller
{
    protected function getSiteSetting(): SiteSetting
    {
        return SiteSetting::query()->first() ?? SiteSetting::query()->create([
            'site_name' => config('app.name'),
        ]);
    }

    /**
     * Show the form for editing the site settings.
     */
    public function edit(): View
    {
        $siteSetting = $this->getSiteSetting();

        return view('admin.site-settings.edit', compact('siteSetting'));
    }

    /**
     * Update the site settings in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_name' => 'required',
            'hero_title' => 'nullable',
            'hero_subtitle' => 'nullable',
            'hero_image' => 'nullable',
            'stat_1_label' => 'nullable',
            'stat_1_value' => 'nullable',
            'stat_2_label' => 'nullable',
            'stat_2_value' => 'nullable',
            'stat_3_label' => 'nullable',
            'stat_3_value' => 'nullable',
        ]);

        $siteSetting = $this->getSiteSetting();
        $siteSetting->update($validated);

        return redirect()->route('site-settings.edit')->with('success', 'Site settings updated successfully.');
    }
}
