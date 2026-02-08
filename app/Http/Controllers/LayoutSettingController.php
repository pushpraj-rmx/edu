<?php

namespace App\Http\Controllers;

use App\Models\LayoutSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LayoutSettingController extends Controller
{
    /**
     * Show the form for editing layout settings.
     */
    public function edit(): View
    {
        $header = LayoutSetting::get('header', LayoutSetting::defaultHeader());
        $footer = LayoutSetting::get('footer', LayoutSetting::defaultFooter());

        return view('admin.layout-settings.edit', compact('header', 'footer'));
    }

    /**
     * Update the layout settings.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'header.logo_alt' => 'nullable|string|max:255',
            'header.nav_links' => 'nullable|array',
            'header.nav_links.*.label' => 'required|string|max:100',
            'header.nav_links.*.url' => 'required|string|max:255',
            'header.nav_links.*.children' => 'nullable|array',
            'header.nav_links.*.children.*.label' => 'required|string|max:100',
            'header.nav_links.*.children.*.url' => 'required|string|max:255',
            'header.cta_button.text' => 'nullable|string|max:50',
            'header.cta_button.url' => 'nullable|string|max:255',
            'header.cta_button.visible' => 'boolean',
            'footer.about_text' => 'nullable|string|max:500',
            'footer.quick_links' => 'nullable|array',
            'footer.quick_links.*.label' => 'required|string|max:100',
            'footer.quick_links.*.url' => 'required|string|max:255',
            'footer.social_links' => 'nullable|array',
            'footer.social_links.*.platform' => 'required|string|in:facebook,twitter,linkedin,instagram,youtube',
            'footer.social_links.*.url' => 'required|url|max:255',
            'footer.contact.address' => 'nullable|string|max:255',
            'footer.contact.phone' => 'nullable|string|max:50',
            'footer.contact.email' => 'nullable|email|max:255',
            'footer.copyright' => 'nullable|string|max:255',
        ]);
        if ($request->hasFile('header_logo_file')) {
            $request->validate(['header_logo_file' => 'image|max:2048']);
        }
        if ($request->hasFile('header_logo_dark_file')) {
            $request->validate(['header_logo_dark_file' => 'image|max:2048']);
        }

        $headerData = $validated['header'] ?? [];
        $headerData['cta_button']['visible'] = $request->boolean('header.cta_button.visible');
        $headerData['nav_links'] = $this->cleanNavLinks($headerData['nav_links'] ?? []);
        $existing = LayoutSetting::get('header', LayoutSetting::defaultHeader());
        if ($request->hasFile('header_logo_file')) {
            $headerData['logo'] = $request->file('header_logo_file')->store('layout', 'public');
        } else {
            $headerData['logo'] = $headerData['logo'] ?? $existing['logo'] ?? null;
        }
        if ($request->hasFile('header_logo_dark_file')) {
            $headerData['logo_dark'] = $request->file('header_logo_dark_file')->store('layout', 'public');
        } else {
            $headerData['logo_dark'] = $headerData['logo_dark'] ?? $existing['logo_dark'] ?? null;
        }

        $footerData = $validated['footer'] ?? [];
        $footerData['quick_links'] = $this->cleanLinks($footerData['quick_links'] ?? []);
        $footerData['social_links'] = $this->cleanLinks($footerData['social_links'] ?? []);

        LayoutSetting::set('header', $headerData);
        LayoutSetting::set('footer', $footerData);

        return redirect()->route('layout-settings.edit')->with('success', 'Layout settings updated successfully.');
    }

    /**
     * Clean nav links, removing empty entries.
     *
     * @param  array<int, array<string, mixed>>  $links
     * @return array<int, array<string, mixed>>
     */
    private function cleanNavLinks(array $links): array
    {
        return collect($links)
            ->filter(fn ($link) => ! empty($link['label']) && ! empty($link['url']))
            ->map(function ($link) {
                $link['children'] = $this->cleanLinks($link['children'] ?? []);

                return $link;
            })
            ->values()
            ->all();
    }

    /**
     * Clean links, removing empty entries.
     *
     * @param  array<int, array<string, mixed>>  $links
     * @return array<int, array<string, mixed>>
     */
    private function cleanLinks(array $links): array
    {
        return collect($links)
            ->filter(fn ($link) => ! empty($link['label'] ?? $link['platform'] ?? null))
            ->values()
            ->all();
    }
}
