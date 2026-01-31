@extends('layouts.admin')

@section('page-title', 'Layout Settings')

@section('content')
    <form method="POST" action="{{ route('layout-settings.update') }}" class="space-y-8">
        @csrf
        @method('PATCH')

        {{-- Header Settings --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Header Settings</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-input-label for="header_logo" :value="__('Logo Path')" />
                        <x-text-input id="header_logo" name="header[logo]" type="text" class="mt-1 block w-full" :value="old('header.logo', $header['logo'] ?? '')" placeholder="uploads/logo.png" />
                        <p class="mt-1 text-sm text-gray-500">Relative path to logo image</p>
                        <x-input-error class="mt-2" :messages="$errors->get('header.logo')" />
                    </div>

                    <div>
                        <x-input-label for="header_logo_alt" :value="__('Logo Alt Text / Site Name')" />
                        <x-text-input id="header_logo_alt" name="header[logo_alt]" type="text" class="mt-1 block w-full" :value="old('header.logo_alt', $header['logo_alt'] ?? '')" />
                        <x-input-error class="mt-2" :messages="$errors->get('header.logo_alt')" />
                    </div>
                </div>

                {{-- Navigation Links --}}
                <div class="mt-6">
                    <x-input-label :value="__('Navigation Links')" class="mb-3" />
                    <div id="nav-links-container" class="space-y-4">
                        @foreach($header['nav_links'] ?? [] as $index => $link)
                            <div class="nav-link-item border rounded-md p-4 bg-gray-50">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <x-input-label :value="__('Label')" />
                                        <x-text-input name="header[nav_links][{{ $index }}][label]" type="text" class="mt-1 block w-full" :value="$link['label'] ?? ''" required />
                                    </div>
                                    <div>
                                        <x-input-label :value="__('URL')" />
                                        <x-text-input name="header[nav_links][{{ $index }}][url]" type="text" class="mt-1 block w-full" :value="$link['url'] ?? ''" required />
                                    </div>
                                </div>

                                {{-- Children (Dropdown Items) --}}
                                <div class="mt-4">
                                    <x-input-label :value="__('Dropdown Items (optional)')" class="mb-2" />
                                    <div class="children-container space-y-2 ml-4">
                                        @foreach($link['children'] ?? [] as $childIndex => $child)
                                            <div class="child-item grid grid-cols-2 gap-2">
                                                <x-text-input name="header[nav_links][{{ $index }}][children][{{ $childIndex }}][label]" type="text" class="block w-full" :value="$child['label'] ?? ''" placeholder="Label" />
                                                <div class="flex gap-2">
                                                    <x-text-input name="header[nav_links][{{ $index }}][children][{{ $childIndex }}][url]" type="text" class="block w-full" :value="$child['url'] ?? ''" placeholder="URL" />
                                                    <button type="button" class="remove-child text-red-600 hover:text-red-800 px-2">&times;</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button type="button" class="add-child mt-2 text-sm text-indigo-600 hover:text-indigo-800">+ Add dropdown item</button>
                                </div>

                                <button type="button" class="remove-nav-link mt-3 text-sm text-red-600 hover:text-red-800">Remove link</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-nav-link" class="mt-4 text-sm text-indigo-600 hover:text-indigo-800">+ Add navigation link</button>
                </div>

                {{-- CTA Button --}}
                <div class="mt-6 pt-6 border-t">
                    <h3 class="font-medium text-gray-900 mb-4">CTA Button</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="header_cta_text" :value="__('Button Text')" />
                            <x-text-input id="header_cta_text" name="header[cta_button][text]" type="text" class="mt-1 block w-full" :value="old('header.cta_button.text', $header['cta_button']['text'] ?? '')" />
                        </div>
                        <div>
                            <x-input-label for="header_cta_url" :value="__('Button URL')" />
                            <x-text-input id="header_cta_url" name="header[cta_button][url]" type="text" class="mt-1 block w-full" :value="old('header.cta_button.url', $header['cta_button']['url'] ?? '')" />
                        </div>
                        <div class="flex items-end">
                            <label class="flex items-center">
                                <input type="checkbox" name="header[cta_button][visible]" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" {{ ($header['cta_button']['visible'] ?? false) ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Show button</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Footer Settings --}}
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-6">Footer Settings</h2>

                <div>
                    <x-input-label for="footer_about_text" :value="__('About Text')" />
                    <textarea id="footer_about_text" name="footer[about_text]" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ old('footer.about_text', $footer['about_text'] ?? '') }}</textarea>
                    <x-input-error class="mt-2" :messages="$errors->get('footer.about_text')" />
                </div>

                {{-- Quick Links --}}
                <div class="mt-6">
                    <x-input-label :value="__('Quick Links')" class="mb-3" />
                    <div id="quick-links-container" class="space-y-2">
                        @foreach($footer['quick_links'] ?? [] as $index => $link)
                            <div class="quick-link-item grid grid-cols-2 gap-2">
                                <x-text-input name="footer[quick_links][{{ $index }}][label]" type="text" class="block w-full" :value="$link['label'] ?? ''" placeholder="Label" />
                                <div class="flex gap-2">
                                    <x-text-input name="footer[quick_links][{{ $index }}][url]" type="text" class="block w-full" :value="$link['url'] ?? ''" placeholder="URL" />
                                    <button type="button" class="remove-quick-link text-red-600 hover:text-red-800 px-2">&times;</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-quick-link" class="mt-2 text-sm text-indigo-600 hover:text-indigo-800">+ Add quick link</button>
                </div>

                {{-- Social Links --}}
                <div class="mt-6">
                    <x-input-label :value="__('Social Links')" class="mb-3" />
                    <div id="social-links-container" class="space-y-2">
                        @foreach($footer['social_links'] ?? [] as $index => $link)
                            <div class="social-link-item grid grid-cols-3 gap-2">
                                <select name="footer[social_links][{{ $index }}][platform]" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="facebook" {{ ($link['platform'] ?? '') === 'facebook' ? 'selected' : '' }}>Facebook</option>
                                    <option value="twitter" {{ ($link['platform'] ?? '') === 'twitter' ? 'selected' : '' }}>Twitter</option>
                                    <option value="linkedin" {{ ($link['platform'] ?? '') === 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                                    <option value="instagram" {{ ($link['platform'] ?? '') === 'instagram' ? 'selected' : '' }}>Instagram</option>
                                    <option value="youtube" {{ ($link['platform'] ?? '') === 'youtube' ? 'selected' : '' }}>YouTube</option>
                                </select>
                                <x-text-input name="footer[social_links][{{ $index }}][url]" type="url" class="block w-full col-span-1" :value="$link['url'] ?? ''" placeholder="https://..." />
                                <button type="button" class="remove-social-link text-red-600 hover:text-red-800 px-2 justify-self-start">&times;</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="add-social-link" class="mt-2 text-sm text-indigo-600 hover:text-indigo-800">+ Add social link</button>
                </div>

                {{-- Contact Info --}}
                <div class="mt-6 pt-6 border-t">
                    <h3 class="font-medium text-gray-900 mb-4">Contact Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="footer_contact_address" :value="__('Address')" />
                            <x-text-input id="footer_contact_address" name="footer[contact][address]" type="text" class="mt-1 block w-full" :value="old('footer.contact.address', $footer['contact']['address'] ?? '')" />
                        </div>
                        <div>
                            <x-input-label for="footer_contact_phone" :value="__('Phone')" />
                            <x-text-input id="footer_contact_phone" name="footer[contact][phone]" type="text" class="mt-1 block w-full" :value="old('footer.contact.phone', $footer['contact']['phone'] ?? '')" />
                        </div>
                        <div>
                            <x-input-label for="footer_contact_email" :value="__('Email')" />
                            <x-text-input id="footer_contact_email" name="footer[contact][email]" type="email" class="mt-1 block w-full" :value="old('footer.contact.email', $footer['contact']['email'] ?? '')" />
                        </div>
                    </div>
                </div>

                {{-- Copyright --}}
                <div class="mt-6">
                    <x-input-label for="footer_copyright" :value="__('Copyright Text')" />
                    <x-text-input id="footer_copyright" name="footer[copyright]" type="text" class="mt-1 block w-full" :value="old('footer.copyright', $footer['copyright'] ?? '')" placeholder="© {{ date('Y') }} Your Company. All rights reserved." />
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Update Layout Settings') }}</x-primary-button>
        </div>
    </form>

    <script>
        let navLinkIndex = {{ count($header['nav_links'] ?? []) }};
        let quickLinkIndex = {{ count($footer['quick_links'] ?? []) }};
        let socialLinkIndex = {{ count($footer['social_links'] ?? []) }};

        // Add nav link
        document.getElementById('add-nav-link')?.addEventListener('click', function() {
            const container = document.getElementById('nav-links-container');
            const template = `
                <div class="nav-link-item border rounded-md p-4 bg-gray-50">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Label</label>
                            <input name="header[nav_links][${navLinkIndex}][label]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">URL</label>
                            <input name="header[nav_links][${navLinkIndex}][url]" type="text" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block font-medium text-sm text-gray-700 mb-2">Dropdown Items (optional)</label>
                        <div class="children-container space-y-2 ml-4"></div>
                        <button type="button" class="add-child mt-2 text-sm text-indigo-600 hover:text-indigo-800">+ Add dropdown item</button>
                    </div>
                    <button type="button" class="remove-nav-link mt-3 text-sm text-red-600 hover:text-red-800">Remove link</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
            navLinkIndex++;
        });

        // Add quick link
        document.getElementById('add-quick-link')?.addEventListener('click', function() {
            const container = document.getElementById('quick-links-container');
            const template = `
                <div class="quick-link-item grid grid-cols-2 gap-2">
                    <input name="footer[quick_links][${quickLinkIndex}][label]" type="text" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Label">
                    <div class="flex gap-2">
                        <input name="footer[quick_links][${quickLinkIndex}][url]" type="text" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="URL">
                        <button type="button" class="remove-quick-link text-red-600 hover:text-red-800 px-2">&times;</button>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
            quickLinkIndex++;
        });

        // Add social link
        document.getElementById('add-social-link')?.addEventListener('click', function() {
            const container = document.getElementById('social-links-container');
            const template = `
                <div class="social-link-item grid grid-cols-3 gap-2">
                    <select name="footer[social_links][${socialLinkIndex}][platform]" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="facebook">Facebook</option>
                        <option value="twitter">Twitter</option>
                        <option value="linkedin">LinkedIn</option>
                        <option value="instagram">Instagram</option>
                        <option value="youtube">YouTube</option>
                    </select>
                    <input name="footer[social_links][${socialLinkIndex}][url]" type="url" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="https://...">
                    <button type="button" class="remove-social-link text-red-600 hover:text-red-800 px-2 justify-self-start">&times;</button>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', template);
            socialLinkIndex++;
        });

        // Remove handlers using event delegation
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-nav-link')) {
                e.target.closest('.nav-link-item').remove();
            }
            if (e.target.classList.contains('remove-quick-link')) {
                e.target.closest('.quick-link-item').remove();
            }
            if (e.target.classList.contains('remove-social-link')) {
                e.target.closest('.social-link-item').remove();
            }
            if (e.target.classList.contains('remove-child')) {
                e.target.closest('.child-item').remove();
            }
            if (e.target.classList.contains('add-child')) {
                const container = e.target.previousElementSibling;
                const navItem = e.target.closest('.nav-link-item');
                const navIndex = Array.from(navItem.parentElement.children).indexOf(navItem);
                const childIndex = container.children.length;
                const template = `
                    <div class="child-item grid grid-cols-2 gap-2">
                        <input name="header[nav_links][${navIndex}][children][${childIndex}][label]" type="text" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Label">
                        <div class="flex gap-2">
                            <input name="header[nav_links][${navIndex}][children][${childIndex}][url]" type="text" class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="URL">
                            <button type="button" class="remove-child text-red-600 hover:text-red-800 px-2">&times;</button>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', template);
            }
        });
    </script>
@endsection
